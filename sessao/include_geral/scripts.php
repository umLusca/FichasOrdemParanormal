<script type="text/babel">
    const modaleditardado = new bootstrap.Modal('#editardado')
    var i = 0, timeOut = 0;
    $(document).on("hidden.bs.toast", () => {
        $("main button").attr("disabled", false)
    });

    function editdado(id, dado, nome, foto) {
        $('#edicone').val(foto);
        $('#eddado').val(dado);
        $('#ednome').val(nome);
        $('#edidd').val(id);
        modaleditardado.toggle();
    }
    
    function rolar(dado1, dado2 = undefined, dado3 = undefined) {

        if (typeof dado1 === "string") {
            console.log("1", typeof dado1);
            console.log("2", typeof dado2);
            console.log("3", typeof dado3);

            let dano, nome, dado;
            dado = dado1;
            typeof dado2 !== "object" && dado2 ? dano = dado2 : dano = false;
            typeof dado3 === "string" ? nome = dado3 : nome = "Teste";

            dado1 = {
                nome: nome,
                dado: dado,
                dano: dano,
            }
            dado2 = undefined;
            dado3 = undefined;
        }
        console.log(dado1)
        let ficha = '<?=$fichat ?: ''?>';


        return new Promise((resolve, reject) => {
            $.ajax({
                url: "",
                method: "post",
                data: {
                    status: "roll",
                    dado: dado1["dado"],
                    dano: dado1["dano"],
                    nome: dado1["nome"],
                    margem: dado1["margem"] ? dado1["margem"] : 20
                    
                },
                dataType: "json",
                beforeSend: () => {
                    $("main button").attr("disabled", true);
                },
                success: (data) => {
                    console.log(data)
                    if (data.success) {
                        socket.emit('<?=$missao_token ?: $fichat?>', {dado: {nome: dado1["nome"], ...data}, ficha: ficha});

                        function RolledDices(p) {
                            let retorno = [];
                            console.log(p);

                            function Critico(p) {
                                return (<span className="fw-bolder text-success fs-6 vibrate">{p.valor}</span>)
                            }

                            $.each(p.data.dados, (i, e) => {
                                let resultados = [];

                                $.each(e.resultados, (ir, er) => {
                                    if (ir !== e.resultados.length - 1) {
                                        if (er >= p.data.margem && !data.dano) {
                                            resultados[resultados.length] = (<span><Critico valor={er}/>,</span>)
                                        } else {
                                            resultados[resultados.length] = (<span>{er}, </span>);
                                        }
                                    } else {
                                        if (er >= p.data.margem && !data.dano) {
                                            resultados[resultados.length] = <Critico valor={er}/>
                                        } else {
                                            resultados[resultados.length] = (<span>{er}</span>)
                                        }
                                    }
                                })

                                retorno[retorno.length] =
                                    <h6 className="text-muted">{e.dado.toUpperCase()}: {resultados}</h6>

                            })

                            return retorno;
                        }

                        if (data["critico"]) {
                            console.log("critou")
                            $("#Toastdados").addClass("border-danger").removeClass("border-info");
                            $("#Toastdados .toast-body").addClass("vibrate");
                        } else if (dado1["dano"]) {
                            $("#Toastdados").addClass("border-danger").removeClass("border-info");
                            $("#Toastdados .toast-body").removeClass("vibrate");
                        } else {
                            console.log("não critou")
                            $("#Toastdados").addClass("border-info").removeClass("border-danger");
                            $("#Toastdados .toast-body").removeClass("vibrate");
                        }

                        let footer = [];
                        if (typeof dado2 === "object") {
                            footer[footer.length] =
                                <button className="btn btn-sm btn-outline-danger" onClick={() => rolar(dado2)}>Rolar
                                    Dano</button>;
                        }
                        if (typeof dado3 === "object") {
                            footer[footer.length] =
                                <button className="btn btn-sm btn-outline-danger" onClick={() => rolar(dado3)}>Rolar
                                    Crítico</button>;
                        }
                        ReactDOM.createRoot($("#Toastdados")[0]).render([
                            <div className="toast-header">
                                <span className="me-auto fs-5">{dado1["nome"]}</span>
                                <button type="button" className="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>,
                            <div className={"toast-body pb-0 " + (data["critico"] ? "vibrate" : "")}>
                                <div>
                                    <h3>Resultado: {data.print}={data.resultado}</h3>
                                    <RolledDices data={data}/>
                                </div>
                            </div>,
                            <div className="toast-footer btn-group w-100">
                                {footer}
                            </div>])
                        new bootstrap.Toast($('#Toastdados')).show();
                        resolve({status: true});
                    } else {
                        ReactDOM.createRoot($("#Toastdados")[0]).render([
                            <div className="toast-header">
                                <span className="me-auto fs-5">{dado1["nome"]}</span>
                                <button type="button" className="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>,
                            <div className={"toast-body pb-0"}>
                                <div>
                                    <h3>Falha...</h3>
                                    <p>{data.msg}</p>
                                </div>
                            </div>])
                        new bootstrap.Toast($('#Toastdados')).show();
                        
                        $("main button").attr("disabled", false);
                        resolve({status: false, ...data});

                    }


                },
                error: () => {
                    
                    $("main button").attr("disabled", false);
                    resolve({status: false});
                },
            })
        })
    }


    $(() => {
        $("#formfastdice input").on("input", () => {
            let dado = $("#formfastdice input").val();
            let pattern = /^[AdDEFGINOPRTV\d/+-]+\S$/g;
            if (!dado.match(pattern) && dado !== "") {
                $("#formfastdice .return").html(`<div class="alert alert-danger">Esse dado não é válido</div>`)
            } else {
                $("#formfastdice .return").html(``)
            }

        })
        $("#formfastdice").on("submit", (t) => {
            t.preventDefault();
            let pattern = /^[AdDEFGINOPRTV\d/+-]+\S$/g;
            let dado = $("#formfastdice input").val();

            console.log(dado);
            if (dado.match(pattern)) {
                rolar({
                    dado: dado,
                    nome: "Teste rápido",
                    dano: false,
                    margem: 100
                }).then((d)=>{
                    if(!d.status){
                        $("#formfastdice .return").html(`<div class="alert alert-danger">${d.msg}</div>`)
                    }
                });
            }

        })

        $("#editardado .deletar").click(function (e) {
            e.preventDefault()
            confirmar("Deseja apagar esse dado?").then(s=>{
                console.log(s)
                if (s){
                    $("#eds").val("deld");
                    $("#editardado").submit();
                }
            })
        })
        $("#editardado .salvar").click(function (e) {
            e.preventDefault()
            $("#eds").val("editd");
            $("#editardado").submit();
        })

        $('#dados .dado').on('mousedown touchstart', function (e) {
            $(this).addClass('active');
            let id = $(this).attr("aria-id");
            let dado = $(this).attr("aria-dado");
            let nome = $(this).attr("aria-nome");
            let foto = $(this).attr("aria-foto");
            timeOut = setInterval(function () {
                clearInterval(timeOut);
                editdado(id, dado, nome, foto);
            }, 500);
        }).bind('mouseup mouseleave touchend', function () {
            $(this).removeClass('active');
            clearInterval(timeOut);
        });


    })
</script>