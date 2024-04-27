<div class="modal" id="maskModal" tabindex="-1" role="dialog" aria-labelledby="maskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="maskModalLabel">Digite o CPF ou CNPJ</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <label for="cpfCnpjInput">Insira com pontuação: <br> (CPF) XXX.XXX.XXX-XX  <br> (CNPJ) XX.XXX.XXX/XXXX-XX</label>
            <input type="text" id="cpfCnpjInput" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" onclick="recalculeTop()">Enviar</button>
        </div>
      </div>
    </div>
</div>
