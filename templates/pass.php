 <div class="modal fade" id="senhaModal" tabindex="-1" role="dialog" aria-labelledby="senhaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="senhaModalLabel">Esqueci minha senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="passForm" id="passForm" method="post" action="exec.esqueci.php">
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">E-mail:</label>
                        <input type="text" class="form-control" name="edtemail" id="edtemail" type="email" require="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="form_submit('passForm')">Solicitar nova senha</button>
            </div>
        </div>
    </div>
</div>