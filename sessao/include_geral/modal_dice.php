<!-- Modal ATRIBUTOS-->
<div class="modal fade" id="rolardados" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black border-light">
            <div class="modal-body">
                <div class="text-center fs-1">Como Criar/Rolar Dados.</h2></div>
                <div class="m-3 text-center">
                    <h3>Principios Basicos</h3>
                    <p>Um dado é composto por <var>N</var> faces depedendo do dado, esse valor fica depois do <code>d</code>.<br>
                        Exemplo: Um dado de 20 lados, será "<code>d20</code>".
                    </p>
                    <br>
                    <p>
                        Para Expressar quantidade de dados, nós colocamos o valor antes do "<code>d</code>".<br>
                        Exemplo: Para rolar 2 dados de 6 lados (sendo que iremos pegar o melhor), será "<code>2d6</code>, 2 de quantidade de dados, e 6 de lados".<br>
                    </p>
                    <br>
                    <p>
                        Agora para poder adicionar um valor fixo depois do resultado do dado, devemos por um "<code>+</code>" depois de tudo.<br>
                        Exemplo: Rolar 1 dado de 20 lados e somar 5 do resultado, ficará "<code>1d20+5</code>" OU "<code>d20+5</code>". (é importante não ter espaços).
                    </p>
                    <br><br>
                    <h5>Aprofundado nos principios</h5>
                    <p>
                        Para rolar dois ou mais dados de lados diferentes, é só usar "<code>+</code>" Entre cada um, deixando a soma para o final.<br>
                        Exemplo: Um dado de 6 lados, somado com um dado de 10 lados, ficará "<code>1d6+1d10</code>" OU "<code>d6+d10</code>".
                    </p>
                    <br><br>
                    <h5>Ficha do player apenas:</h5>
                    <p>
                        Para usar algum atributo como, por exemplo, FORÇA basta adicionar "<code>/FOR/</code>".<br>
                        Exemplos: Rolar 2d20 somando FORÇA, "<code>2d20+/FOR/</code>".
                    </p>
                    <br>
                    <p>
                        Para modificar os valores do atributo usando operações matemática, basta usar no módulo.<br>
                        Exemplo: 2d10 mais o dobro de FORÇA, "<code>2d10+/FOR*2/</code>".<br>
                        Exemplo: 4d4 mais Vigor menos 2 "<code>4d4+/VIG-2/</code>".
                    </p>
                    <br>
                    <p>
                        Há, Também uma forma e rolar com atributo como base.<br>
                        Exemplos: FOR = 2, "<code>/FOR/d20</code>" -> "<code>2d20</code>".<br>
                        Também é possível rolar uma quantidade de lados usando os atributos<br>
                        Exemplos: AGI = 4, "<code>1d/FOR/</code>" -> "<code>1d4</code>".<br>
                        E claro usar tudo de uma vez.<br>
                        Exemplos: AGI = 2, FOR = 3, INT = 4: "<code>/AGI/d/FOR/+/INT/</code>" -> "<code>2d3+4</code>".<br>
                        Pode parecer confuso, mas é bem explicátivo.<br>
                    </p>
                    <br><br>
                    <h5>Lembrando que:</h5>
                    <ol>
                        <li>Dados podem ter lados, quantidades, e soma customizados.</li>
                        <li>Não pode rolar mais de 10 dados em cada item. (Errado:"<code>15d10</code>" Certo:"<code>10d10+5d10</code>").</li>
                        <li>Não pode rolar dados com mais de 100 lados, o limite é 100.</li>
                        <li>Não pode somar mais de 30 absolutamente(Negativo ou possitivo)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="adddado" tabindex="-1">
    <form class="modal-dialog" method="post" id="formadddado">
        <div class="modal-content bg-black border-light">
            <div class="text-center modal-header border-bottom-0">
                <h2 class="modal-title">Adicionar Dado.</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-3">
                    <div class="m-2">
                        <label class="fs-4" for="icone">Icone</label>
                        <select class="form-select bg-black text-light" id="icone" name="icone" required="required">
                            <option value="1" >D4</option>
                            <option value="2" >D6</option>
                            <option value="3" >D8</option>
                            <option value="4" >D10</option>
                            <option value="5" >D12</option>
                            <option value="6" selected>D20</option>
                            <option value="7" >D6 - lado 1</option>
                            <option value="8" >D6 - lado 2</option>
                            <option value="9" >D6 - lado 3</option>
                            <option value="10" >D6 - lado 4</option>
                            <option value="11" >D6 - lado 5</option>
                            <option value="12" >D6 - lado 6</option>
                        </select>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="dnome">Nome (Opcional)</label>
                        <input id="dnome" class="form-control bg-black  text-light " type="text" maxlength="20" placeholder="Dado de Ferro" name="nome"/>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="ddado">Dados</label>
                        <input id="ddado" class="form-control bg-black  text-light" type="text" maxlength="20" name="dado" placeholder="1d20+5" required/>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchdano" name="dano">
                        <label class="form-check-label" for="switchdano" >Rolar como dano (Soma todos os dados)</label>
                    </div>
                    <input type="hidden" name="status" value="addd"/>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button class="btn btn-outline-success" type="submit">Criar</button>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="editardado" tabindex="-1">
    <form class="modal-dialog" method="post" id="formeditdado">
        <div class="modal-content bg-black border-light">
            <div class="modal-header border-bottom-0">
                <h2>Editar Dado.</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-3">
                    <div class="m-2">
                        <label class="fs-4" for="eddicone">Icone</label>
                        <select class="form-select bg-black text-light" id="eddicone" name="icone" required="required">
                            <option value="1" >D4</option>
                            <option value="2" >D6</option>
                            <option value="3" >D8</option>
                            <option value="4" >D10</option>
                            <option value="5" >D12</option>
                            <option value="6" selected>D20</option>
                            <option value="7" >D6 - lado 1</option>
                            <option value="8" >D6 - lado 2</option>
                            <option value="9" >D6 - lado 3</option>
                            <option value="10" >D6 - lado 4</option>
                            <option value="11" >D6 - lado 5</option>
                            <option value="12" >D6 - lado 6</option>
                        </select>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="ednome">Nome (Opcional)</label>
                        <input id="ednome" class="form-control bg-black  text-light" type="text" maxlength="20" name="nome" placeholder="Dado de ferro"/>
                    </div>
                    <div class="m-2">
                        <label class="fs-4" for="eddado">Dados</label>
                        <input id="eddado" class="form-control bg-black  text-light" type="text" maxlength="20" name="dado" placeholder="1d20+5" required/>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="eswitchdano" name="dano" value="1" <?=$dado["dano"]?'CHECKED':''?>>
                        <label class="form-check-label" for="eswitchdano" >Rolar como dano (Soma todos os dados)</label>
                    </div>
                </div>
                <input type="hidden" id="eds" name="status" value=""/>
                <input type="hidden" id="edidd" name="did"/>
            </div>
            <div class="clearfix m-3">
                <button class="btn btn-outline-success float-end" type="submit" id="sed">Salvar</button>
                <button class="btn btn-outline-danger float-start" type="submit" id="ded">Deletar</button>
            </div>
        </div>
    </form>
</div>


<div class="position-fixed top-50 start-50 translate-middle">
    <div class="toast bg-black text-light border-dark" id="Toastdados" role="alert" data-bs-autohide="false" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-dark">
            <strong class="me-auto">Resultado</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div id="resultado">
            <span class="font6 fs-1"></span>
                <span id="dado1"></span>:<span id="valores1"></span>
            </div>
        </div>
    </div>
</div>