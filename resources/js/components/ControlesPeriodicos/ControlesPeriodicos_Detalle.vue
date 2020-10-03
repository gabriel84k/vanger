<template>
    <div id="Modal-ControlPeriodico-detalle" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
           
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header card-header shadow-sm">
                <h4 class="modal-title">Detalle del Control </h4>
                <button type="button" class="close" data-dismiss="modal" @click="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
               
                <comp-Inspecciones :Inspdatos="datos" :RP="idRP"></comp-Inspecciones>
            </div>
            <div class="modal-footer shadow-lg">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cerrar</button>
            </div>
            </div>

        </div>
    </div>
</template>
<script>
    //const $ = require('jquery') //usamos jquery
    //window.$ = $ //lo colocamos de forma global
    import inspecciones from '../Inspecciones/Inspecciones'
export default {
     
    props:['datos','idRP','control'],
    data() {
        return {
            errored:false,
            loading:false,
            
        }
    },
    mounted(){
        
    },
    methods: {
        closeModal:function(){
            $('#Modal-ControlPeriodico-detalle').hide()
            $('#Modal-ControlPeriodico-detalle').toggleClass('show')
         },
        
    },
}
</script>