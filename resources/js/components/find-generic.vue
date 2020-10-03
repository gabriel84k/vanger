<template>
<div class="">
    <div class="form-row accordion" id="accordionExample">
        <div class="col-md-4 mb-2">
            <div class="input-group">
                <div class="input-group-prepend" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="Más filtros">
                    <button class="collapsed btn btn-success fa fa-filter" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"></button>
                </div>
                <input id="filt_tabla" type="text" class="form-control" v-on:keyup="filtrar_tabla()" placeholder="Filtrar datos en tabla">
            </div>
        </div>
        <div id="collapseThree" class="collapse col-12" aria-labelledby="headingThree" data-parent="#accordionExample">
            <form id='form-buscar' ref="form">
                <div class="row">
                    <div class="col-md-4 col-sm-12" v-for="(filter, index) in find.filters" :key="index">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default" v-text="filter.span_text"></span>
                            </div>
                            <select v-if="filter.input_type == 'select'" @keyup="buscar()" @change="buscar()"
                                    class="form-control custom-select" :title="filter.span_text"
                                    v-model="find.params[filter.select_model]">
                                <option value="">- Todos -</option>
                                <option v-for="data in find.data_select[filter.data_select]" :key="data.id" :value="data.id">
                                    {{data[filter.input_name]}}
                                </option>
                            </select>
                            <input v-else :type="filter.input_type" class="form-control" @keyup="buscar()"
                                    :name="filter.input_name" v-model="find.params[filter.input_name]"
                                    aria-label="Default" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
</template>

<script>

    const $ = require('jquery') //usamos jquery
    window.$ = $ //lo colocamos de forma global

export default {

    props:['find', 'RP'],

    methods: {
        /*-[Obtiene todos los Inspecciones]-*/
        buscar:function(){
            try {
                
                var params = this.find.params;

                axios.get(this.find.url+this.RP, {params} )
                    .then(response => {
                        
                        this.$emit('search', response.data)
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)

            } catch (error) {

            }
        },
        filtrar_tabla:function(){
            var valorabuscar = $("#filt_tabla").val().toUpperCase();
            
            var tabla_tr =$("#mytable .vuetable tbody tr"); 
           
            $.each(tabla_tr,function(k,tr){
               var textotr=""; 
              
                if(($(tr).find('td').text().toUpperCase().includes(valorabuscar)==true)) {
                    $(tr).removeClass('ocultar');
                    $(tr).addClass("mostrar");
                } else {
                    $(tr).removeClass("mostrar");
                    $(tr).addClass("ocultar");
                }
                    
                
            });

           
        },
    }
}
</script>
