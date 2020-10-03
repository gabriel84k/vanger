<template>
     <div class="">
        <table id="example" class="table display nowrap dataTable dtr-inline collapsed">
            <tbody>
                <tr>
                    
                    <div v-for="s in sucursal" 
                         :key="s.id"  
                         class="btn-lg" >
                            
                        {{hab_excel(s.sectores)}}
                          
                        <div class="input-group-prepend panel-heading"   tabindex="0" data-toggle="popover" data-trigger="hover" data-content="Expandir..." >
                            <div class=" col-md-12">
                                <td :class="s.config.sucursal.classnombre"
                                    :style="s.config.sucursal.stylenombre">
                                    {{s.nombre}}
                                </td>
                                <td>
                                    &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                    <a  :href="'../Export/Sucursal/' + s.id" 
                                        :class="'btn btn-success'+ disabled" 
                                        :title="s.config.sucursal.tooltip">
                                        <i :class="s.config.sucursal.classicon" aria-hidden="true"></i>
                                        &nbsp;&nbsp;
                                        
                                        <span class="glyphicon glyphicon-save">{{s.config.sucursal.textexcel}}</span>
                                    </a>
                                        
                                </td>
                                <td >
                                    <div class="unactive stretched-link" 
                                         style="cursor: pointer;" 
                                         @click="expandir('#collapseExample',s.idsucursal)">
                                         <i :class="'expand' +s.idsucursal+' fas fa-angle-double-up'"></i>
                                    </div>
                                    
                                </td>
                            </div>
                        </div>
                        <hr>
                        <div class="collapse" :id="'collapseExample'+s.idsucursal" >
                            <div class="card card-header">
                                <div class="row">
                                    <div class="col-md-9"> 
                                        <i class="fa-sigex-title"> </i>
                                        <span class="badge badge-secondary">{{s.config.sector.nombre}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-for="(sect) in s.sectores"  :key="sect.id" class="sector">
                               
                               
                                <div v-if="sect.puestos.data.length>0" class="card card-body" style=""> 
                                    
                                    {{cargaPuestos(sect.puestos,sect.id)}}
                                    <div >
                                        <div class="row">
                                            
                                            <div :class="s.config.sector.classnombre">
                                                <h5 :style="s.config.sector.stylenombre">Nombre del Sector: {{sect.nombre}}</h5>
                                            </div>
                                            <div v-show="false" class="col-md-2">
                                                <a :href="'../Export/Sectores/'+sect.id" :class="'btn btn-success'+ disabled">
                                                    <i class="fa fa-file-excel-o fa fa-download" aria-hidden="true"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                    <span class="glyphicon glyphicon-save"></span>
                                                </a>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="unactive stretched-link" style="cursor: pointer;" @click="expandirsector('#collapsesector',sect.id)">
                                                    <i :class="'expandsector'+ sect.id + ' fas fa-angle-double-down'"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="collapse" :id='"collapsesector"+sect.id'>
                                            <div class="card tabla-sucursal">
                                                <div  class=" card-body" style="overflow-x: auto;">
                                                    
                                                    <vuetable ref="vuetable"
                                                        :id="sect.id"
                                                        :fields="fields"
                                                        :api-mode="false"
                                                        :row-class="fila_err"
                                                        :data="puesto[sect.id]"
                                                        :show-sort-icons="false"
                                                        :css="css.table"
                                                        pagination-path=""
                                                        
                                                        @vuetable:loaded="constr(puesto[sect.id].data)"

                                                        >
                                                    
                                                        <template v-if="true" slot="btndetalle" slot-scope="props">
                                                            <div class="table-button-container">
                                                                <button type="button" 
                                                                    :class="s.config.puestos.btnclass" 
                                                                    :style="s.config.puestos.btnstyle"
                                                                    @click="verpuesto(props.rowData)">
                                                                    {{s.config.puestos.btnnombre}}
                                                                
                                                                </button>
                                                                
                                                            </div>
                                                        </template>
                                                        
                                                        <template slot="habilitado" slot-scope="props">
                                                                {{habilitado(props.rowData.habilitado)}}
                                                        </template>
                                                        
                                                        <template slot="element" slot-scope="props">
                                                            <div  class="table-button-container">
                                                                {{_elemento(props.rowData.tipopuesto)}}
                                                            </div>
                                                        </template>
                                                    </vuetable>
                                                    <br>
                                                    <Comp-pagination  ref="pagination"
                                                        :vuepableid="sect.id"
                                                        :data="sect.puestos"
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
                    </div>
                </tr>   
            </tbody>
            <tfoot>
               
            </tfoot>
        </table>
        
        <!--<DetalleElemento :detalles="ElementDetalle.detalle" :datos="ElementDetalle.datos" :param="ElementDetalle.parametros"></DetalleElemento>-->
        <DetallePuesto  :detalles="PuestoDetalle.detalle" :datos="PuestoDetalle.datos" :param="PuestoDetalle.parametros"></DetallePuesto>
        
    </div>
</template>
<script>
import CssVuetable from '../StyleDataTable/DataTable_Nr';
import DetallePuesto from '../Puestos/Puesto_Detalle';


export default {
    props:['param'],
    data(){
      return {
            ElementDetalle:{detalle:{},datos:{},parametros:this.param},
            puesto:[],
            sucursal:[],
            sucursal_detalle:[],
           
            PuestoDetalle:{detalle:{},datos:{},parametros:this.param},
            datos:[],
            showModal:false,
            errored:false,
            disabled:' disabled',
            css:CssVuetable,
            fields:[],
      }
    },
    components: {
        DetallePuesto,
        
    },
    mounted(){
        this.show('/home/Sucursales/data')
    },
    methods: {
       
        pagination (url,tableid) {         /*-pagination : [traela url de la paginacion y el id de la vue table] */
            this.show(url)
        },
        fila_err:function(dataItem,i){    /* •Función que setea el color de la fila si habilitado es [SI o No] . */
            if (dataItem.habilitado!=0){
                    this.classerr=false
                    return ''
            }else{
                    this.classerr=true
                    return 'alert alert-warning'
            }
        },
        constr(col){                   /* •Metodo en el cual se construyen las columnas de la vuetable usa [$column de los modelos] */
            let c=0
            let field=[]
            let ColPuesto=''
            /* Utili<amos las columnas de la clase Puestos */
            $.each(col, function (indexcol, valpuesto) { 
                if (valpuesto){
                    ColPuesto=valpuesto.columnas
                }
            });
            $.each(ColPuesto, function (index, value) { 
                var item={}
                if (value.name=='row_type'){
                   item= {
                        'name':value.name,
                        'title':value.muestra,
                        'visible':value.visible,
                        formatter (value) {
                            return value.toUpperCase().replace("SEGUSUR","").replace("ESACALERA","ESCALERA").replace("EGUSUR"," DE DERRAME");
                        }
                    }
                }else{
                   item= {
                        'name':value.name,
                        'title':value.muestra,
                        'visible':value.visible
                    }
                }
                field[c++]=item
            });
            this.fields=field
        },
        show:function(page){           /* •cargaPuestos : [carga la vuetable] */
            try {
                axios.get(page)
                    .then(response => {
                        this.constr(response.data)
                        this.sucursal=response.data
                        $.each(response.data,function(key,val){
                            if (response.data.sectores===null){
                                this.disable_excel='disabled'
                            }
                        });
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            } catch (error) {
            }
        },
        cargaPuestos:function(Puestos,id){ /* •Carga Puestos : [carga la vuetable] */
            this.puesto[id]=Puestos
        },
        habilitado:function(h){       /* •Función que setea la columna de habilitado en [SI o No] . */
            if (h==1){
                return 'Sí';
            }else{  
                return "No";
            }
        },
        verpuesto(rowData){   
            
            /* •Habilita el detalle del Puesto. */
           
            this.PuestoDetalle.detalle=rowData
            this.PuestoDetalle.datos=rowData.tipopuesto.inspecciones
            this.PuestoDetalle.parametros=this.param
             
            $('#Modal-Puesto-detalle').modal('show')
        },
        verequipo(rowData){           /* •No se utiliza pero se puede habilitar para mostrar el detalle del elemento. */
            this.ElementDetalle.detalle=rowData.tipopuesto.element
            this.ElementDetalle.datos=rowData.tipopuesto.inspecciones
            this.ElementDetalle.parametros=this.param
             
            $('#Modal-Equipo-detalle').modal('show')
        },
        formatDate:function(value,h,f){/*•Funcion de Formateo de fecha. */
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
        hab_excel:function(value){    /* •Habilita el boton del pdf cuando existen datos para descargar.*/
            if (value==''){
                this.disabled=' disabled'
            }else{
                this.disabled=''
            }
        },
        expandir(obj,id){             /* •Funciones exclusivas para expandir los puestos y sectores.*/
            $(obj+id).toggleClass('show');
            $(obj+id).toggleClass('collapse');
            if ($(obj+id).hasClass('show')){
                 $('.expand'+id).removeClass('fa-angle-double-up') 
                 $('.expand'+id).addClass('fa-angle-double-down') 
            }else{
                $('.expand'+id).removeClass('fa-angle-double-down') 
                $('.expand'+id).addClass('fa-angle-double-up') 
            }

        },
        expandirsector(obj,id){      /* •Funciones exclusivas para expandir los puestos y sectores.*/
            $(obj+id).toggleClass('show');
            $(obj+id).toggleClass('collapse');
            if ($(obj+id).hasClass('show')){
                $('.expandsector'+id).removeClass('fa-angle-double-down') 
                $('.expandsector'+id).addClass('fa-angle-double-up') 
            }else{
                $('.expandsector'+id).removeClass('fa-angle-double-up') 
                $('.expandsector'+id).addClass('fa-angle-double-down') 
            }
        },
        _elemento(Tipo){             /* •Genera el nombre del elemento dependiendo si es [manguera, equipos, bombas] */
            if (Tipo.elemento!=null){
                switch (Tipo.elemento.row_type) {
                    case 'mangueras':
                        return  Tipo.elemento.tipoelemento.numeroManguera+'  ('
                                +Number(Tipo.elemento.tipoelemento.diametromili.toFixed(3))+ ' mm) '  
                                +Tipo.elemento.tipoelemento.longitudmili + ' mts';
                        break;
                
                    case "equipos":
                        return ''+Tipo.elemento.tipoelemento.nro_equipo_evolution+' ['
                                +Tipo.elemento.tipoelemento.tipo+ ']  '
                                +Tipo.elemento.tipoelemento.capacidad;
                        break;
                    case "bombas":
                        return '';
                        break;
                    default:
                        return 'no tienee';
                        break;
                }
            }else{return Tipo.codigoElemento}           
        }
    }
}
</script>
