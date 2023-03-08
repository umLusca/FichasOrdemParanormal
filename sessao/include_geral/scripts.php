<script type="text/babel">
    const ToastDados = new bootstrap.Toast($('#Toastdados'));
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
    
    function rolar(dados) {
        console.log("teste")
        if(!(dados instanceof Array)){
            dados = [dados];
        }
        let ficha = '<?=$token ?: ''?>';

        return new Promise((resolve, reject) => {
            $.ajax({
                url: "",
                method: "post",
                data: {
                    query: "rolar_dado",
                    dado: dados[0]["dado"],
                    dano: dados[0]["dano"],
                    nome: dados[0]["nome"],
                    margem: dados[0]["margem"] ? dados[0]["margem"] : 20
                    
                },
                dataType: "json",
                beforeSend: () => {
                    $("main button").attr("disabled", true);
                },
                success: (data) => {
                    console.log(data);
                    if (data["success"]) {
                        data = data.dado
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
                        } else if (dados[0]["dano"]) {
                            $("#Toastdados").addClass("border-danger").removeClass("border-info");
                            $("#Toastdados .toast-body").removeClass("vibrate");
                        } else {
                            console.log("não critou")
                            $("#Toastdados").addClass("border-info").removeClass("border-danger");
                            $("#Toastdados .toast-body").removeClass("vibrate");
                        }

                        let footer = [];
                        if (typeof dados[1] === "object") {
                            footer[footer.length] =
                                <button className="btn btn-sm btn-outline-danger" onClick={() => rolar(dados[1])}>Rolar
                                    Dano</button>;
                        }
                        if (typeof dados[2] === "object") {
                            footer[footer.length] =
                                <button className="btn btn-sm btn-outline-danger" onClick={() => rolar(dados[2])}>Rolar
                                    Crítico</button>;
                        }
                        ReactDOM.createRoot($("#Toastdados")[0]).render([
                            <div className="toast-header">
                                <span className="me-auto fs-5">{dados[0]["nome"]}</span>
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
                        ToastDados.show();
                        resolve({status: true});
                    } else {
                        ReactDOM.createRoot($("#Toastdados")[0]).render([
                            <div className="toast-header">
                                <span className="me-auto fs-5">{dados[0]["nome"]}</span>
                                <button type="button" className="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>,
                            <div className={"toast-body pb-0"}>
                                <div>
                                    <h3>Falha...</h3>
                                    <p>{data["msg"]}</p>
                                </div>
                            </div>])
                        ToastDados.show();
                        
                        $("main button").attr("disabled", false);
                        resolve({status: false, ...data});

                    }


                },
                error: (d) => {
                    console.log(d);
                    ReactDOM.createRoot($("#Toastdados")[0]).render([
                        <div className="toast-header">
                            <span className="me-auto fs-5">Erro de conexão</span>
                            <button type="button" className="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>,
                        <div className={"toast-body pb-0"}>
                            <div>
                                <h3>Falha...</h3>
                                <p>Houve um erro, verifique sua internet...</p>
                            </div>
                        </div>])
                    ToastDados.show();
                    $("main button").attr("disabled", false);
                    resolve({status: false});
                },
            })
        })
    }

    let pattern = /^([+-]?((100|\d{1,2}|\/[ADEFGINOPRTV]{3,4}\/)?((d)(100|[1-9]\d?|\/[ADEFGINOPRTV]{3,4}\/))?)|(\d{0,3}|1000))([+-]((100|\d{1,2}|\/[ADEFGINOPRTV]{3,4}\/)?((d)(100|[1-9]\d?|\/[ADEFGINOPRTV]{3,4}\/))?)|([+-]\d{0,3}|1000)?)*$/g;
    
    
    
    $(() => {
        $("#formfastdice input").on("input", () => {
            let dado = $("#formfastdice input").val();
            if (!dado.match(pattern) && dado !== "") {
                $("#formfastdice .return").html(`<div class="alert alert-danger">Esse dado é inválido, para dúvidas clique em <i class="far fa-circle-info"></i></div>`)
            } else {
                $("#formfastdice .return").html(``)
            }

        })
        $("#formfastdice").on("submit", (t) => {
            t.preventDefault();
            let dado = $("#formfastdice input").val();

            console.log(dado);
            if (dado.match(pattern)) {
                rolar({
                    dado: dado,
                    nome: "Teste rápido",
                    dano: false,
                    margem: 100
                })
            }

        })

        $("#editardado .deletar").click(function (e) {
            e.preventDefault()
            confirmar("Deseja apagar esse dado?").then(s=>{
                console.log(s)
                if (s){
                    $("#eds").val("delete_dado_customizado");
                    $("#editardado").submit();
                }
            })
        })
        $("#editardado .salvar").click(function (e) {
            e.preventDefault()
            $("#eds").val("edit_dado_customizado");
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