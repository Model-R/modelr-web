<div class="form-group">
    <label for="cmboxtipofiltro">Tipo</label>
    <select id="cmboxtipofiltro" name="cmboxtipofiltro" class="form-control">
        <option value="USUARIO" <?php if ($tipofiltro=='USUARIO') echo "selected";?>>Usuário</option>
        <option value="EXPERIMENTO" <?php if ($tipofiltro=='EXPERIMENTO') echo "selected";?>>Experimento</option>
        <option value="GRUPO" <?php if ($tipofiltro=='GRUPO') echo "selected";?>>Grupo</option>
    </select>
</div>