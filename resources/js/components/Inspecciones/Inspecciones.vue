<template>
    <div class="">
        
        <Buscar-component v-show="visualizador('buscador')" :find="filters" v-on:search="search" :RP="RP.id"></Buscar-component>
       
        <div v-if="visualizador('buscador')" class=" card container">
            <div class=" row card-header">
                <div class="col-sm-8">
                    <h5 style="line-height: 2;">
                        <strong>{{Inspdatos.data[0].config.general.titulo}}</strong>
                    </h5>
                    
                </div>
                <div class="col-sm-2">
                    <div class="dropdown">
                        <a class="btn btn-outline-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Inspdatos.data[0].config.general.combopdf}}
                        </a>
                      
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                            <a v-for="(item,key,i) in Inspdatos.data" :key="i" class="dropdown-item" :href="'/imprimir/Inspecciones/tipo/'+RP.id+'/'+item.row_type">
                            
                                {{item.row_type.replace('inspeccion','').replace('segusur','').replace('egusur',' de derrame').toLowerCase()+'s'}}
                            </a>
                                                  
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <a :href="'/imprimir/Inspecciones/'+RP.id+'/'+RP.nrocontrol" :class="''" title="Inspecciones Pdf">
                        <i class="fa fa-file-pdf-o fa fa-download" aria-hidden="true"></i>
                             {{Inspdatos.data[0].config.general.botonpdf}}
                        <span class="glyphicon glyphicon-save"></span>
                    </a>
                </div>
            </div>
        </div>
       
        <vuetable ref="vuetable"
            
            id="mytable"
            :row-class="fila_estado"
            :fields="fields"
            :api-mode="false"
            :data="Inspdatos"
            :show-sort-icons="false"
            :css="css.table"
            @vuetable:loaded="constr(Inspdatos.data)"
            >
            <template slot="accion" slot-scope="props">
                <button type="button" 
                            data-toggle="modal" 
                            data-target="#Modal-insp-detalle" 
                            :class="props.rowData.config.filas.botondetalle.clase"
                            @click="show_detalle(props.rowData)" 
                            :style="props.rowData.config.filas.botondetalle.style">
                            {{props.rowData.config.filas.botondetalle.nombre}}
                </button>
                
            </template>
            <template slot="incidencias" slot-scope="props">
                
                <popper
                    v-if="props.rowData.incidencias"
                    trigger="clickToOpen"
                    :options="{
                    placement: 'top',
                    modifiers: { offset: { offset: '0,10px' } }
                    }">
                    <div class="popper">
                         {{props.rowData.incidencias}}
                    </div>
                
                    <a href="#" slot="reference" :style="props.rowData.config.incidencias.style">
                        
                        {{props.rowData.incidencias.slice(props.rowData.config.incidencias.inicio,props.rowData.config.incidencias.fin)+'...'}}
                    </a>
                </popper>
            </template>
            <template slot="imagenes" slot-scope="props">
                
                <div v-show="(props.rowData.fotos.length!=0)" class="dropdown">
                   
                    <button :class="'btn  dropdown-toggle ' + BotonOp(props.rowData) " type="button" id="Boton-Img" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       {{props.rowData.config.filas.combofoto.nombre}}
                    </button>
                   
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a v-for="fx in props.rowData.fotos" :key="fx.id" @click="ver_img(fx.url,fx.descripcion,props.rowData.config)" data-toggle="modal"  data-target="#exampleModal"  class="dropdown-item "   title="Ver Imagen" style="cursor:pointer">
                            <i class="fa fa-picture-o"></i> - {{fx.foto}}
                        </a>
                    </div>
                </div>
            </template>
            
            <template slot="estado" slot-scope="props" >
                {{estado(props.rowData.estado)}}
            </template>
            <template slot="fechahora" slot-scope="props">
                <div class="table-button-container">
                    {{formatDate(props.rowData.fechahora,false,4)}}
                
                </div>
            </template>
            <template slot="elemento" slot-scope="props">
                <div class="table-button-container">
                    {{ColElemento(props.rowData)}}
                
                </div>
            </template>
        </vuetable>
        <br>
        <Comp-pagination  ref="pagination"
            :vuepableid="'inspecciones'"
            :data="Inspdatos"
            @click="pagination"
        >
        </Comp-pagination>
        
       <Comp-Imagenes :image="img" :desc="descripcion" :conf="config"></Comp-Imagenes>
       <inspDetalle :detalles="Inspecciones_detalle" ></inspDetalle>
     
    </div>
</template>
<script>
  
    import CssVuetable from '../StyleDataTable/DataTable_Nr';
    import inspDetalle from './inspeccion_detalle'
    import Popper from 'vue-popperjs';
    import 'vue-popperjs/dist/vue-popper.css';
    
export default {
    name:"Componente-Inspecciones",
    props:{
        RP:{required: false},
        Inspdatos:{required: false},
        visualize:{
                type: Number,
                default: 0,
                required: false
                }
    },
    data(){
      return {
        classerr:'',
        descripcion:'',
        img:'', 
        config:'',
        nameadapt:'',
        Inspecciones:[],
        Inspecciones_detalle:[],
        fields:[],
        filters: {
            url: "/home/Inspecciones/search/",
            params: {
                    puesto:'',
                    tipo:'',
                    sector:'',
                    incidencia:''
                     },
            data_select:{
                //sust_select:[{id:2,value:'SI'},{id:1,value:'NO'}]
            },
            filters: [
                { span_text: "Puesto", input_type: "text", input_name: "puesto" },
                { span_text: "Tipo", input_type: "text", input_name: "tipo" },
                { span_text: "Sector", input_type: "text", input_name: "sector" },
                { span_text: "Incidencia", input_type: "text", input_name: "incidencia" },
                
                //{ span_text: "Sustituto", input_type: "select", input_name: "value",data_select:'sust_select', select_model:"sustituto" },
                
            ]
        },
        css:CssVuetable,
      }
    },
    components: {
        inspDetalle,
        Popper
        
    },
   
    mounted() {
        $('#prueba').popover();
    },
  
    methods: {
        
        fila_estado:function(dataItem,i){   /* •Pinta de color la fila si exite un detalle de incidencias*/
                //console.log(dataItem)
                if (dataItem.incidencias==null){
                        return ''
                }else{
                        return dataItem.config.filas.fila_estado//'alert alert-danger'
                }
        },
        estado:function(e){                /* •Setea el valor del estado en [cumple o no cumple] */
             if (e==1){
               return "Cumple"
           }else{
               return "NO cumple"
           }
        },
        constr(col){                       /* •Constructor de columnas de vuetable */
            let c=0
            let field=[]
            
            console.log('columans.....')
            console.log(col)
            /* Columnas Automaticas */
            if (col){
                let Colinspec=''
                $.each(col, function (indexcol, valinsp) { 
                
                    if (valinsp){
                        Colinspec=valinsp.columnas
                    }
                });
                $.each(Colinspec, function (index, value) { 
                    var item={}
                
                    if (value.visible!=false && value.hasOwnProperty('func')!=false ){
                        if (value.func[0]=='row_type'){
                            item= {
                                    'name':value.name,
                                    'title':value.muestra,
                                    'visible':value.visible,
                                    formatter (value) {
                                        return value.toUpperCase().replace("SEGUSUR","").replace("EGUSUR"," DE DERRAME");
                                    }
                            }
                        }
                    }else if (value.name=='incidencias'){
                        item= {
                                'name':value.name,
                                'title':value.muestra,
                                'visible':value.visible,
                                formatter (value) {
                                    if (value){
                                        return value
                                    }else{
                                        return 'Sin Incidencias'
                                    }
                                }
                            }
                    }else{
                    item= {
                            'name':value.name,
                            'title':value.muestra,
                            'visible':value.visible,
                        }
                    }
                    field[c++]=item
                });

                this.fields=field
            }else{
                this.fields=[]
            }
        },
        show:function(page){               /* •Funcion principal en la cual se obtiene las inspecciones */
               
                try {
                    axios.get(page)
                        .then(response => { 
                            this.constr(response.data)
                            this.Inspdatos=response.data
                        })
                        .catch(error => {
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                    
                } catch (error) {
                    
                }
        },
        show_detalle(row){                 /* •Muestra el detalle de la inspección */
            this.Inspecciones_detalle=row
        },
        pagination (url,tableid) {         /* •Pagination : [traela url de la paginacion y el id de la vue table] */
          
            this.show(url)
        },
        search:function(e){                /* •Resultado de la busqueda */
            this.Inspdatos=e     
        },
        formatDate:function(value,h,f){    /* •Formato fecha */
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
        BotonOp:function(val){             /* •Habilita el boton desplegar para ver las fotos */
            
            if (val.fotos.length>0){
                return val.config.filas.combofoto.habilitado;
            }else{
                return val.config.filas.combofoto.deshabilitad;
            }
        },
        ver_img:function(i,d,conf){             /* •Selecciona la imagen a visualizar*/
            this.config=conf
            this.img=i
            this.descripcion=d
        },
        visualizador(colum){                  /* •Muestra u oculta el filtro en la inspeccion cuando se muestra en los detalles del puesto o equipo*/
            if (this.Inspdatos){
                if(this.visualize!==0){
                    switch (colum) {
                        case 'buscador':
                            return false
                            break;
                    }
                }else{
                    switch (colum) {
                        case 'buscador':
                            return true
                            break;
                    
                    }
                }
            }else{
                return false
            }
            
        },
        ColElemento(rowdata){
            if (rowdata.elemento){
                switch (rowdata.row_type) {
                    case 'inspeccionextintor':
                        return rowdata.elemento.nro_equipo_evolution+'  ['+rowdata.elemento.tipo+']  '+rowdata.elemento.capacidad+'  '+this.nulleabled(rowdata.elemento.unidad)
                        
                    case 'inspeccionbie':
                        return rowdata.elemento.numeroManguera+'  ('+rowdata.elemento.longitudReal+' mts)  '+Number(rowdata.elemento.diametromili.toFixed(3))+' mm'
                        
                }
            }else{
                if (rowdata.DetalleInspeccion.codigoelemento){
                    return '['+rowdata.DetalleInspeccion.codigoelemento+']'
                }else{
                    return 'Elemento Ausente'
                }
                
            }
        },
        nulleabled(val){
            if (val){
                return val
            }else{
                return ''
            }
        }
    }
}

$(document).ready(function(){
    $('#prueba').popover();
    
});
$(document).on("click",".close",function(){
       $('[data-toggle="popover"]').popover('hide');
});
</script>

