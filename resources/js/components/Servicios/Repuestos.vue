<template>
    <div id="Modal-repuestos-detalle" :key="idplanilla" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
               
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header card-header shadow-sm">
                        <h4 class="modal-title">Detalle Repuestos</h4>
                        <button type="button" class="close"  @click="close()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="m-widget1 col">
                            <div class="m-widget1__item">
                                <div class="card">
                                    <!--
                                    <Buscar-component :find="filters" v-on:search="search" :RP="this.RP"></Buscar-component>
                                    -->
                                    <div class="container">
                                        <div class="row card-header">
                                            <div class="col-sm ">
                                                <h5><strong>Repuestos</strong></h5>
                                            </div>
                                        </div>
                                    </div>
                       
                                    <vuetable ref="vuetable"
                                        id="mytable"
                                        :fields="fields"
                                        :api-mode="false"
                                        :data="repuestos"
                                        :show-sort-icons="false"
                                        :css="css.table"
                                        >
                                        <!--
                                        <template slot="Cap_equipo" slot-scope="props">
                                            <div class="table-button-container">
                                                {{props.rowData.capacidad+' '+props.rowData.unidad}}
                                            </div>
                                        </template>                                
                                        -->
                                    </vuetable>
                                    <br>
                                    <Comp-pagination  ref="pagination"
                                        :data="repuestos"
                                        @click="pagination"
                                    >
                                    </Comp-pagination>
                                    
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</template>
<script>
    import CssVuetable from '../StyleDataTable/DataTable_Nr';
export default {
    props:['idplanilla', 'repuestos'],
    data() {
        return {
            css:CssVuetable,
            fields:[{
                    name:'id',
                    title:'#',
                    visible:false,
                },{
                    name:'idrepsigex',
                    title:'Id Repuesto',
                    visible:false,
                },{
                    name:'repuesto.nombre',
                    title:'Nombre',
                },{
                    name:'repuesto.abreviatura',
                    title:'Abreviatura',
                },{
                    name:'resultado',
                    title:'Resultado',
                    formatter (value) {
                        switch (value) {
                            case 1:
                                return 'Inspeccion Visual';
                                break;
                            case 2:
                                return 'Reparado';
                                break;
                            case 3:
                                return 'Reemplazado';
                                break;
                            case 4:
                                return 'Servicio';
                                break;
                        }
                        
                    }
            }],
        }
    },
    mounted() {
        
    },
    methods: {
        index:function(page){
            try {
                axios.get(page)
                    .then(response => {
                        this.repuestos=response.data
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        pagination(url,tableid) {         /*-pagination : [traela url de la paginacion y el id de la vue table] */
            this.index(url)
        },
        close(){
            $("#Modal-repuestos-detalle").modal('hide')
        }
    },
}
</script>