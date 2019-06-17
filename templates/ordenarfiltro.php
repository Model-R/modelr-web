<div class="form-group">
    <label for="cmboxordenar">Ordenar por</label>
    <select id="cmboxordenar" name="cmboxordenar" class="form-control">
        <option value="USUARIO" <?php if ($ordenapor=='USUARIO') echo "selected";?>>Usuário</option>
        <option value="EXPERIMENTO" <?php if ($ordenapor=='EXPERIMENTO') echo "selected";?>>Experimento</option>
        <option value="GRUPO" <?php if ($tipofiltro=='GRUPO') echo "selected";?>>Grupo</option>
    </select>
</div>