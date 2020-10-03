<template>
<div id="Modal-servicio-detalle" :class="'modal fade '+ show" role="dialog">
        <div class="modal-dialog modal-xl">
           
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header card-header shadow-sm">
                    <h4 class="modal-title">Detalle Servicios</h4>
                    <button type="button" class="close" data-dismiss="modal" @click="close()">&times;</button>
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
                                        <div class="col-sm " >
                                            <h5 style="line-height: 2;"><strong>Servicios Realizados</strong></h5>
                                            
                                           
                                        </div>
                                        <a :href="'/imprimir/Inutilizacion/'+planilla" :class="'btn btn-success'+ disabled" title="Inutilización">
                                            <i class="fa fa-file-pdf-o fa fa-download" aria-hidden="true"></i>
                                            Inutilización
                                            <span class="glyphicon glyphicon-save"></span>
                                        </a>
                                        <a :href="'/imprimir/Operatividad/'+planilla"  :class="'btn btn-success'+ disabled" title="Operatividad">
                                            <i class="fa fa-file-pdf-o fa fa-download" aria-hidden="true"></i>
                                            Operatividad
                                            <span class="glyphicon glyphicon-save"></span>
                                        </a>
                                        <!-- Se deshabilita a pedido de vanger por ahora... -->
                                        <a v-if="false" :href="'/imprimir/GrupoCertCarga/'+planilla" :class="'btn btn-success'+ disabled" title="Certificado de carga">
                                            <i class="fa fa-file-pdf-o fa fa-download" aria-hidden="true"></i>
                                            Certificado de carga
                                            <span class="glyphicon glyphicon-save"></span>
                                        </a>
                                        
                                        <a v-if="false" :href="'/imprimir/CertificadoPH/'+planilla+'/0'" :class="'btn btn-success'+ disabled" title="Certificado de PH ">
                                            <i class="fa fa-file-pdf-o fa fa-download" aria-hidden="true"></i>
                                            Certificado de PH 
                                            <span class="glyphicon glyphicon-save"></span>
                                        </a>
                                        
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="col-sm ">
                                            <h5><strong></strong></h5>
                                        </div>
                                </div>
                                <vuetable ref="vuetable"
                                    id="mytable"
                                    :row-class="fila_estado"
                                    :fields="constr(detalles)"
                                    :api-mode="false"
                                    :data="detalles"
                                    :show-sort-icons="false"
                                    :css="css.table"
                                    >
                                    <template slot="Cap_equipo" slot-scope="props">
                                        <div class="table-button-container">
                                            {{capacidad(props.rowData.elemento.equipos.capacidad,props.rowData.elemento.equipos.unidad)}}
                                            
                                        </div>
                                    </template>
                                     
                                    <template slot="realizoPH" slot-scope="props">
                                        <div class="table-button-container">
                                            <a v-if="(props.rowData.realizoPH==1)" :href="'/imprimir/CertificadoPH/'+planilla+'/'+props.rowData.equipos_id"  :class="'btn btn-success'+ disabled" title="Descargar Pdf">
                                                SI
                                            </a>
                                             <a v-else  :class="'btn btn-success'+ disabled" title="">
                                                {{realizoPH(props.rowData.realizoPH)}}
                                            </a>
                                        </div>
                                    </template>
                                     <template slot="rechazos" slot-scope="props">
                                            
                                            <div v-show="(props.rowData.rechazos.length>0)" class="btn-group dropright">
                                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ver...
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a v-for="item in props.rowData.rechazos" :key="item.id" class="dropdown-item" href="#">{{item.motivo}}</a>
                                                   
                                                </div>
                                            </div>
                                    </template>
                                    <template slot="elemento.equipos.vencimiento_ph" slot-scope="props">
                                        <div class="table-button-container">
                                           
                                            {{formatDate(props.rowData.elemento.equipos.vencimiento_ph,false,5)}}
                                        </div>
                                    </template>
                                    <template slot="elemento.equipos.vencimiento_carga" slot-scope="props">
                                        <div class="table-button-container">
                                            {{formatDate(props.rowData.elemento.equipos.vencimiento_carga,false,5)}}
                                        </div>
                                    </template>
                                    <template slot="elemento.equipos.fecha_fabricacion" slot-scope="props">
                                        <div class="table-button-container">
                                            {{ff(props.rowData.elemento.equipos.fecha_fabricacion)}}
                                        
                                        </div>
                                    </template>
                                    <template slot="Acc" slot-scope="props">
                                    
                                        <button v-show="(props.rowData.CantRepuesto!=0)"  type="button" class="btn btn-sm  btn-outline-success" data-toggle="modal"  data-target="#Modal-repuestos-detalle" @click="DataRep(props.rowData)">Repuestos</button>
                                       
                                    </template>
                                
                                </vuetable>
                                <br>
                                <Comp-pagination  ref="pagination"
                                    :vuepableid="'servicios'"
                                    :data="detalles"
                                    @click="pagination"
                                >
                                </Comp-pagination>
                               
                            <repuestos  :idplanilla="repuesto.idp" :repuestos="repuesto.data"></repuestos>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

</template>
<style scoped>
    .vuetable-body > tr >td{
        font-size: 10px;
        text-align: center;
    }
</style>
<script>
   
    import CssVuetable from '../StyleDataTable/DataTable_Md';
    import repuestos from './Repuestos';
   
export default {
    name:"Componente-Servicio",
    props:['detalles', 'show','planilla','param'],
    data(){
      return {
        repuesto:{
            idp:0, 
            mostrar: false,
            data:[], 
        },
        disabled:true,
        classerr:'',
        descripcion:'',
        img:'',
        Servicios_detalle:[],
        fields:[],
        filters: {
            url: "/home/servicios/data/",
            params: {
                    id_rp:'',
                    puesto:'',
                    agente:'',
                    capacidad:'',
                    Fdesde:'',
                    Fhasta:'',
                    Ffabricacion:'',
                    sustituto:'' },
            data_select:{
                sust_select:[{id:2,value:'SI'},{id:1,value:'NO'}]
            },
            filters: [
                { span_text: "Puesto", input_type: "text", input_name: "puesto" },
                { span_text: "Agente", input_type: "text", input_name: "agente" },
                { span_text: "Capacidad", input_type: "text", input_name: "capacidad" },
                //{ span_text: "codinterno", input_type: "text", input_name: "codinterno" },
                //{ span_text: "Fdesde", input_type: "date", input_name: "Fdesde" },
                //{ span_text: "Fhasta", input_type: "date", input_name: "Fhasta" },
                { span_text: "Fecha fab.", input_type: "date", input_name: "Ffabricacion" },
                { span_text: "Sustituto", input_type: "select", input_name: "value",data_select:'sust_select', select_model:"sustituto" },
                
            ]
        },
        css:CssVuetable,
      }
    },
    components: {
        repuestos,
    },
    mounted() {
        this.constr(this.detalles)
        
    },
    methods: {
        
        fila_estado:function(dataItem,i){
            return ''
            if (dataItem.estado==1){
                    this.classerr=false
                    return ''
            }else{
                    this.classerr=true
                    return 'alert alert-success'
            }
        },
        constr(col){
            let c=0
            let field=[]
            let fieldservicio=[]
            console.log('Empieza columnas')
            if (col.data){
            /* Columnas de extintores */
                let extintor=col.data[0].elemento.columnas;

                fieldservicio.push({
                    name:'elemento.equipos.' + extintor['nro_equipo_evolution'].name,
                    title:extintor['nro_equipo_evolution'].muestra,
                    visible:true, 
                },{
                    name:'elemento.equipos.' + extintor['tipo'].name,
                    title:extintor['tipo'].muestra,
                    visible:true, 
                },{
                    name:'Cap_equipo',
                    title:extintor['capacidad'].muestra,
                    visible:true, 
                },{
                    name:'elemento.equipos.' + extintor['marca'].name,
                    title:extintor['marca'].muestra,
                    visible:true, 
                },{
                    name:'elemento.equipos.' + extintor['fecha_ultimo_ph'].name,
                    title:extintor['fecha_ultimo_ph'].muestra,
                    visible:true, 
                },{
                    name:'elemento.equipos.' + extintor['fecha_fabricacion'].name,
                    title:extintor['fecha_fabricacion'].muestra,
                    visible:true, 
                },{
                    name:'elemento.equipos.' + extintor['vencimiento_carga'].name,
                    title:extintor['vencimiento_carga'].muestra,
                    visible:true, 
                },{
                    name:'elemento.equipos.' + extintor['vencimiento_ph'].name,
                    title:extintor['vencimiento_ph'].muestra,
                    visible:true, 
                
                })
           
            /* Columnas Automaticas */
                let ColServicio=col.data[0].columnas
                $.each(ColServicio, function (index, value) { 
                    if (value.name=='calificacion'){
                        fieldservicio.push({
                            name:value.name,
                            title:value.muestra,
                            visible:value.visible,
                            formatter (value) {
                                switch (value) {
                                    case 1:
                                        return 'Aprobado';
                                        break;
                                    case 2:
                                        return 'Rechazado';
                                        break;
                                    case 3:
                                        return 'Vigente';
                                        break;
                                }
                            }
                        })
                    }else if(value.name=='servicioARealizar'){
                        fieldservicio.push({
                            name:'servicioARealizar',
                            title:'Servicio Realizado',
                            visible:true,//this.visualize('servicioARealizar'),
                            formatter (value) {
                                switch (value) {
                                    case 'C':
                                        return 'Matenimiento';
                                        break;
                                    case 'GA':
                                        return 'Garantía';
                                        break;
                                    case 'NU':
                                        return 'Nuevo Equipo';
                                        break;
                                    case 'RP':
                                        return 'Revision Periodica';
                                        break;
                                }
                                
                            }
                        })
                    }else if(value.name=='estado'){
                        fieldservicio.push({
                            name:value.name,
                            title:value.muestra,
                            visible:value.visible,
                            formatter (value) {
                                switch (value) {
                                    case 1:
                                        return 'Fichado';
                                        break;
                                    case 2:
                                        return 'En proceso';
                                        break;
                                    case 3:
                                        return 'Reparado';
                                        break;
                                    case 4:
                                        return 'Terminado';
                                        break;
                                    case 5:
                                        return 'Entregado';
                                        break;
                                }
                            }
                        });
                    }else{
                        fieldservicio.push({
                            name:value.name,
                            title:value.muestra,
                            visible:value.visible
                        })
                    }
                });

            /* Columnas Personalizadas */
                
                fieldservicio.push({
                    name:'Acc',
                    title:'Detalle',
                    visible:true//this.visualize('Acc'), 
                })

                field.push(fieldservicio)
            
            /* Botones de Accion */
                return field[0]
            }else{
                return []
            }
        },
        index:function(page){
            try {
                axios.get(page)
                    .then(response => {
                        this.detalles=response.data
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        DataRep:function(data){
           
            this.repuesto.idp=data.id
            try {
                axios.get('/home/Servicios/repuestos/'+data.idsigexservicio)
                    .then(response => {
                        this.repuesto.data=response.data
                        if(response.data){
                            this.repuesto.data.mostrar=true
                        }else{
                            this.repuesto.data.mostrar=false
                        }
                        
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
        search:function(e){
            //this.Inspdatos=e     
        },
        formatDate:function(value,h,f){
            
            if (value){
               
                var arr=value.split(' ')
                let date=arr[0].split('-')
                
                if (h==true){
                    var hora=String(date[0]);
                    var minuto=String(date[1]);
                    var segundo=String(date[2]);
                    
                    return date[2] + '/' + date[1] + '/' + date[0] +'  '+ hora +':'+ minuto +':'+ segundo;
                }else{
                    if (f==2){
                        return date[1] + '/' + String(date[0]).substr(-2,2)
                    
                    }else if(f==4){
                        return date[2] + '/' + date[1] + '/' + date[0];

                    }else if(f==5){
                        return  date[1] + '/' + date[0];
                    }
                }
            }else{
                return ''
            }
        },
        ff(fecha){
            if (fecha.length<3){
                if (fecha[0]<4){
                    fecha="20"+fecha
                }else{
                    fecha="19"+fecha
                }
            }
            return fecha
        },
        close(){
            $("#Modal-servicio-detalle").modal('hide')
        },
        visualize(colum){
            switch (colum) {
                case 'Acc':
                        console.log(this.param.Repuesto)
                        return this.param.Repuesto
                    break;
            }
        },
        fila_estado:function(dataItem,i){
           
            if (dataItem.calificacion==2){
                   return 'alert alert-danger'
            }else{
                   return ''
                    
            }
        },
        capacidad(cap,unidad){
            if (cap==null){
                cap=''
            }
            if(unidad==null){
                unidad=''
            }

            return cap+' '+unidad
        },
        realizoPH(value) {
            switch (value) {
                case null:
                    return 'NO';
                    break;
                case 0:
                    return 'NO';
                    break;
                case 1:
                    return 'SI';
                    break;
                
            }
        }
        
    }
}

</script>