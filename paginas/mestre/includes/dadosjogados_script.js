function ReloadDados() {
    $("#dados_recentes").load(" #dados_recentes>*");
    setTimeout(ReloadDados,2000)
}
ReloadDados();