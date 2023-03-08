<style>
    .portrait {
        position: relative;
        width: 2000px;
        height: 1000px;
    }

    .personagem {
        --tamanho: 850px;
        position: absolute;
        height: var(--tamanho);
        width: var(--tamanho);
        left: 1.25%;
        bottom: 12.5%;
        border-radius: 0% 0% 100% 100%;
    }

    .fundo {
        position: absolute;
        width: 900px;
        height: 900px;
    }

    .marca {
        position: absolute;
        width: 135%;
        height: 135%;
        margin: 0%;
        opacity: 75%;
    }
    * {
        --verme: #CB0300;
    }
    .status {
        position: absolute;
        margin-top: 27.5%;
        margin-left: 25%;
        border: 20px solid var(--verme);
        width: -webkit-fill-available;
    }

    .espadas {
        position: absolute;
        margin-top: 15%;
        margin-left: 50%;
        filter: brightness(0.5);
        width: var(--espada);
        height: var(--espada);
        --espada: 900px;
    }

    .status .PV.progress {
        margin-left: 19%;
        background-color: black;
    }

    .status .PV.progress .progress-bar {
        background-color: #620000;
    }

    .status .SAN.progress {
        margin-left: 5%;
        background-color: black;
    }

    .status .SAN.progress .progress-bar {
        background-color: #262626;
    }

    .PE {
        background-image: url('/assets/img/portrait_fumaca.png');
        filter: drop-shadow(5px 5px 0 black) drop-shadow(5px 5px 0 black);
        animation: sprite 2.5s steps(91) infinite;
        position: absolute;
        margin-top: 30%;
        margin-left: -5%;
        height: 256px;
        width: 256px;
        zoom: 150%;
    }

    .pea {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) !important;
        font-size: 80px;
        text-shadow: 1px 1px 10px;
    }


    .nome {
        position: absolute;
        margin-top: 20%;
        margin-left: 46%;
        width: -webkit-fill-available;
        word-spacing: -0.5rem;
        font-size: 120px;
        font-family: emoji;
        text-shadow: 0 0 7px #b2b2b2,
        0 0 10px #b2b2b2,
        0 0 21px #b2b2b2,
        0 0 92px rgb(0, 0, 0);
    }


    .breath {
        animation: breath 4s infinite;
    }

    .fs-0 {
        font-size: 100px;
    }


    .morto .pri {
        animation: morto 2s linear forwards;
    }

    .morto .espadas {
        animation: mortohide 2s linear forwards;
    }

    .morto .sec, .morto .PE, .morto .status, .morto .fundo {
        animation: sec 2s linear forwards;;
    }

    .morto .nome {
        font-family: Sigilos;
    }

    #portrait {
        margin: 5%;
    }


    .dado {
        zoom: 150%;
        display: none;
        position: absolute;
        margin-top: 2.5%;
        margin-left: 2.5%;
        width: 540px;
        height: 540px;
    }

    .dado .resultado {
        text-align: center;
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .active.dado {
        display: unset;
    !important;
        background-image: url('/assets/img/sprite_dados.png');
        animation: anim 6750ms steps(217);
        opacity: 0%;
    }

    .active.dado .resultado {
        display: unset;
    !important;
        animation: dado 6750ms linear;
        font-size: 200px;
        opacity: 0%;
        color: #ffffff;
    }

    @keyframes sprite {
        from {
            background-position: 0;
        }
        to {
            background-position: -23296px;
        }
    }

    @keyframes breath {

        0% {
            transform: scaleY(100%) translateY(0) rotate(0);
            margin-top: 0;
        }
        60% {
            transform: scaleY(102%) translateY(-1%) rotate(-1deg);
            margin-top: 0;
        }
        90% {
            transform: scaleY(99.5%) translateY(0.25%) rotate(0.5deg);
            margin-top: 0;
        }
    }

    @keyframes morto {
        from {
            filter: brightness(100%);
        }
        to {
            filter: brightness(0%);
        }
    }

    @keyframes mortohide {
        from {
            opacity: 100%;
        }
        to {
            opacity: 0%;
        }
    }

    @keyframes sec {
        from {
            filter: brightness(100%);
        }
        to {
            filter: brightness(30%);
        }
    }

    @keyframes dado {

        0%, 60% {
            opacity: 0%;
        }

        70%, 90% {
            opacity: 100%;
            font-size: 200px;
        }
        100% {
            font-size: 0;
            opacity: 0%;
        }
    }

    @keyframes anim {
        0% {
            background-position: 0;
            opacity: 0%;
        }
        25% {
            opacity: 100%;
        }
        100% {
            opacity: 100%;
            background-position: -117180px;
        }
    }
</style>