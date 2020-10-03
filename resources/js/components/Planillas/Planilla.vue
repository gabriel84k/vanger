<template> 
    <div class="">
       
        <Buscar-component v-show="visualize('buscador')" :find="filters" v-on:search="search" :RP="''"></Buscar-component>
        <div class="">
            <vuetable ref="vuetable"
                :fields="fields"
                :row-class="fila_estado"
                :api-mode="false"
                :data="planilla"
                :show-sort-icons="true"
                :css="css.table"
                pagination-path=""
                id="mytable"
                >
                <template slot="accion" slot-scope="props" >
                    <button type="button" class="btn btn-outline-success" data-toggle="modal"  data-target="#Modal-servicio-detalle" @click="open(props.rowData.id)">Abrir</button>
                </template>
                <template slot="fecha_servicio" slot-scope="props">
                <div class="table-button-container">
                    {{formatDate(props.rowData.fecha_servicio,false,4)}}
                
                </div>
            </template>
            </vuetable>
            <br>
            <Comp-pagination  ref="pagination"
                :vuepableid="'mytable'"
                :data="planilla"
                @click="pagination"
            >
            </Comp-pagination>
        </div>
        <DetallePlanilla 
            :planilla="idplanilla"  
            :detalles="Planilla_detalle" 
            :show="showModal" 
            :param="param">
        </DetallePlanilla>
    </div>
</template>
<script>
    
    import CssVuetable from '../StyleDataTable/DataTable_Nr';
    import DetallePlanilla from '../Servicios/Servicios';


export default {
    name:"Component-Planilla",
    props:{
        param:{ required: false},
        idequipo:{
                type: Number,
                default: 0,
                required: false
                }
    },
    data(){
      return {
        _estado:'',
        planilla:[],
        idplanilla:0,
        Planilla_detalle:[],
        errored:false,
        loading:false,
        datos:[],
        sucursales:[{id:'1',value:'Baja'},{id:'0',value:'Alta'}],
        showModal:'',
        css:CssVuetable,
        fields:[/*
            {
                name:'id',
                title:'Id Planilla',
                visible:false,
              
            },{
                name:'fecha_servicio',
                title:'Fecha de servicio',
               
            },{
                name:'nro_planilla',
                title:'Nro. Planilla',
                
            },{
                name:'cantidadMat',
                title:'Cant. Equipo',
            },{
                name:'orden_trabajo',
                title:'Orden de Trabajo',
                
            },{ 
                name:'nombre',
                title:'Sucursal',
                visible:this.visualize('nombre')
            },{
                name:'estado',
                title:'Estado',
                visible:this.visualize('idEstado'),
                formatter(value){
                     switch (value) {
                        case 1:
                            return 'Iniciada';
                            break;
                        case 2:
                            return 'Fichada';
                            break;
                        case 3:
                            return 'En Proceso';
                            break;
                        case 4:
                            return 'Reparada';
                            break;
                        case 5:
                            return 'Estampillada';
                            break;
                        case 6:
                            return 'Terminada';
                            break;
                        case 7:
                            return 'Entregada';
                            break;
                        case 8:
                            return 'Cancelado';
                            break;
                    }
                }
            },{
                name:'accion',
                title:'Acciones',
                visible:this.visualize('accion'),
            },{
                name:'realizoPH',
                title:'PH',
                visible:this.visualize('realizoPH'),
                formatter (value) {
                    switch (value) {
                        case '0':
                            return 'NO';
                            break;
                        case '1':
                            return 'SI';
                            break;
                    }
                }
            },{
                name:'calificacion',
                title:'Calificación',
                visible:this.visualize('calificacion'),
                formatter (value) {
                    switch (value) {
                        case '1':
                            return 'Aprobado';
                            break;
                        case '2':
                            return 'Rechazado';
                            break;
                        case '3':
                            return 'Vigente';
                            break;
                    }
                }
            },{
                name:'estado',
                title:'Estado',
                visible:this.visualize('estado'),
                formatter (value) {
                    switch (value) {
                        case '1':
                            return 'Fichado';
                            break;
                        case '2':
                            return 'En proceso';
                            break;
                        case '3':
                            return 'Reparado';
                            break;
                        case '4':
                            return 'Terminado';
                            break;
                        case '5':
                            return 'Entregado';
                            break;
                    }
                }
            },{
                name:'servicioARealizar',
                title:'Servicio Realizado',
                visible:this.visualize('servicioARealizar'),
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
            },{
                name:'observaciones',
                title:'Observaciones',
                visible:this.visualize('observaciones'),
                
            }*/],
        filters: {
            url: "/home/Planilla/search",
            params: { fservicio:'', nroplantilla:'', orden:'', sucursal:'',},
            data_select:{
                estado_select:[{id:'1',value:'Baja'},{id:'0',value:'Alta'}],
                
            },
            filters: [
                { span_text: "Número de Planilla", input_type: "text", input_name: "nroplantilla" },
                { span_text: "Orden de Trabajo", input_type: "text", input_name: "orden" },
                { span_text: "Fecha de Servicio", input_type: "date", input_name: "fservicio" },
                { span_text: "Sucursal", input_type: "text", input_name: "sucursal" },
                
            ]
        },
        paginationData:[]
      }
    },
    components: {
        DetallePlanilla
    },
    mounted(){
            
              
            if (this.idequipo!=0){
                console.log('idequipo: '+ this.idequipo)
                this.showDetalle('/home/Planilla/searchequipo/'+this.idequipo)
            }else{
                this.show('/home/Planilla/data')
            }
    },
    methods: {
     
        open:function(idplanilla){
                
                try {
                    axios.get('/home/Servicios/data/'+idplanilla)
                        .then(response => {
                            this.idplanilla=idplanilla
                            this.Planilla_detalle=response.data
                            this.showModal='show';
                            $('#Modal-servicio-detalle').toggleClass('show')
                            $('#Modal-servicio-detalle').show()
                            $('#Modal-servicio-detalle').toggleClass('show')
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                    
                } catch (error) {
                    console.log(error)
                }
        },
        constr(col){
            let c=0
            var item=[]
            let field=[]
            
            /* Columnas Automaticas */
            let ColPlanilla=col[0].columnas
            $.each(ColPlanilla, function (index, value) { 
                item.push({
                    'name':value.name,
                    'title':value.muestra,
                    'visible':value.visible,
                })
            });

            /* Columnas Personalizadas */
            item.push({
                name:'realizoPH',
                title:'PH',
                visible:this.visualize('realizoPH'),
                formatter (value) {
                    switch (value) {
                        case 0:
                            return 'NO';
                            break;
                        case 1:
                            return 'SI';
                            break;
                    }
                }
            })
            
            item.push({
                name:'calificacion',
                title:'Calificación',
                visible:this.visualize('calificacion'),
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
            item.push({
                name:'estado',
                title:'Estado',
                visible:this.visualize('estado'),
                formatter(value){
                    switch (value) {
                        case 1:
                            return 'Iniciada';
                            break;
                        case 2:
                            return 'Fichada';
                            break;
                        case 3:
                            return 'En Proceso';
                            break;
                        case 4:
                            return 'Reparada';
                            break;
                        case 5:
                            return 'Estampillada';
                            break;
                        case 6:
                            return 'Terminada';
                            break;
                        case 7:
                            return 'Entregada';
                            break;
                        case 8:
                            return 'Cancelado';
                            break;
                    }
                }
            })
            item.push({
                name:'nombre',
                title:'Sucursal',
                visible:this.visualize('nombre')
            })
            item.push({
                name:'accion',
                title:'Acciones',
                visible:true//this.visualize('accion')
            })
           
            /* Botones de Accion */
            field.push(item)
           
            this.fields=field[0]
        },
        show:function(page,params){
            try {
                console.log('entro en el show parametros: '+params)
                axios.get(page,{params})
                    .then(response => {
                        this.constr(response.data.data)
                        this.planilla=response.data
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        showDetalle:function(page){
            try {
                axios.get(page)
                        .then(response => {
                            
                            this.constr(response.data.data)
                            this.planilla=response.data
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                    
            } catch (error) {
                
            }
        },
        pagination (url,tableid) {         /*-pagination : [traela url de la paginacion y el id de la vue table] */
            var params = this.filters.params;
            this.show(url,params)
        },
        search:function(e){
            this.planilla=e      
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
        estado:function(value){
            if (value==0){
                this._estado='Vigente';
                return 'alert-primary';

            }else{
                this._estado='Vencido';
                return 'alert-danger';
            }
        },
        visualize(colum){
            if(this.idequipo!==0){
                switch (colum) {
                    case 'accion':
                        return false
                        break;

                    case 'idEstado':
                        return false
                        break;

                    case 'nombre':
                        return false
                        break;

                    case 'buscador':
                        return false
                        break;
                    default:
                        return true
                        break;
                }
            }else{
                switch (colum) {
                    case 'accion':
                        return true
                        break;

                    case 'idEstado':
                        return true
                        break;

                    case 'nombre':
                        return true
                        break;

                    case 'buscador':
                        return true
                        break;

                    default:
                        return false
                        break;
                }
            }
        },
        fila_estado:function(dataItem,i){
         
            if (dataItem.observaciones=='RECHAZADO'){
                   return 'alert alert-success'
            }else{
                   return ''
                    
            }
        },

    }
}
</script>