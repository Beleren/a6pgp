<template>
    <div class="container">
        <!-- Quantidade de Recursos -->
        <div class="form-group">
            <label for="quantidade_recurso" class="control-label">Quantidade de Rercurso</label>
            <input type="number" id="quantidade_recurso" name="quantidade_recurso[]"
            class="form-control">
        </div>

        <!-- Data de Disponbilização do Recurso -->
        <div class="form-group">
            <label for="data_inicio_disp_recurso" class="control-label">
                Data de Disponibilização do Recurso
            </label>
            <input type="date" id="data_inicio_disp_recurso" name="data_inicio_disp_recurso"
                class="form-control">
        </div>

        <!-- Tempo Alocado -->
        <div class="form-group">
            <label for="tempo_alocado" class="control-label">
                Tempo Alocado:
            </label>
            <input type="time" id="tempo_alocado" name="tempo_alocado" class="form-control">
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>