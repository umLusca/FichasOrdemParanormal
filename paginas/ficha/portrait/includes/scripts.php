<script>
    const portrait = ReactDOM.createRoot(
        document.getElementById('portrait')
    );

    const status = {
        pv: <?=$ficha["pv"]?>,
        pva: <?=$ficha["pva"]?>,
        san: <?=$ficha["san"]?>,
        sana: <?=$ficha["sana"]?>,
        pe: <?=$ficha["pe"]?>,
        pea: <?=$ficha["pea"]?>,
        morto: <?=$ficha["morrendo"]?>,
        combate: <?=isset($dados_missao) ? $dados_missao["combate"] : $ficha["combate"]?>,
    };
    const fotos = {
        normal: "<?=$urlphoto?>",
        fer: "<?=$urlphotofer?>",
        enl: "<?=$urlphotoenl?>",
        ferenl: "<?=$urlphotoef?>",
        mor: "<?=$urlphotomor?>",
    }

    let pv, pva, san, sana, pe, pea;

    let opv = <?=$ficha["opv"]?>;
    let ope = <?=$ficha["ope"]?>;
    let osan = <?=$ficha["osan"]?>;
    let foto = "<?=$morrendo ? $urlphotomor : ($enlouquecendo ? $urlphotoenl : ($ppv < 50 ? ($urlphotofer ?: $urlphoto) : $urlphoto));?>";
    let marca = "<?=$marca ?: false?>";
    let elemento = '<?=$elemento?>';
    let dado = '';
    let valordado = '';
    let nome = '<?php $y = ''; $x = explode(' ', $nome); foreach ($x as $nome): $y .= $nome . '\n';endforeach; echo $y;?>';
    const timer = 3000;
    let time;
    let el;


    function hide() {
        dado = '';
        tick();
    }

    function show() {
        dado = 'show';
        setTimeout(hide, 3000);
        tick();
    }

    //Nova function dado
    let last_date, resultado

    

    function subtimer() {
        clearTimeout(time);
        time = setTimeout(show, timer);
    }

    function mostrarresultado(valor) {
        console.log(valor)
        $(".dado .resultado").text(valor)
        $(".dado").addClass("active");

        setTimeout(() => {
            $(".dado").removeClass("active");
        }, 6750);
    }

    function updtsaude() {
        if (opv) {
            pv = pva = "??";
        } else {
            pv = status["pv"];
            pva = status["pva"];
        }
        if (ope) {
            pe = pea = "??";
        } else {
            pe = status["pe"];
            pea = status["pea"];
        }
        if (osan) {
            san = sana = "??";
        } else {
            san = status["san"];
            sana = status["sana"];
        }


        if (status["morto"]) {
            $("#portrait").addClass("morto");
            foto = fotos["mor"]
        } else {
            $("#portrait").removeClass("morto");
            if (pva <= 0) {
                foto = fotos["mor"]
            } else if (sana <= 0) {
                if (percent(pva, pv) < 50) {
                    foto = fotos["ferenl"]
                } else {
                    foto = fotos["enl"];
                }
            } else if (percent(pva, pv) < 50) {
                foto = fotos["fer"];
            } else {
                foto = fotos["normal"];
            }
        }

    }


    function percent(max, min = 0) {
        if ((max === 0 && min === 0) || max === 0) {
            return 0;
        }
        const p = (max / min) * 100;
        if (p > 100) {
            return 100;
        } else {
            return p;
        }
    }

    $(() => {
        function updt() {
            $.ajax({
                url: "",
                method: "post",
                data: {query: "sync_portrait", token: "<?=$token?>"},
                success: (d) => {
                    if (d.success) {
                        if (d.data) {
                            status["combate"] = d.data.combate;
                            status["morto"] = d.data.mor;
                            status["pv"] = d.data.pv;
                            status["pva"] = d.data.pva;
                            status["san"] = d.data.san;
                            status["sana"] = d.data.sana;
                            status["pea"] = d.data.pea;
                            opv = d.data.opv;
                            ope = d.data.ope;
                            osan = d.data.osan;
                        }
                        if (d["dado"]) {
                            if (d["dado"]["data"] !== last_date) {
                                console.log(d["dado"])
                                last_date = d["dado"]["data"];
                                resultado = d["dado"]["resultado"];

                                mostrarresultado(d["dado"]["resultado"]);
                            }
                        }
                    }
                    tick();
                }
            });
            setTimeout(updt, 2500)
        }

        updt();

        tick();
    })
</script>
