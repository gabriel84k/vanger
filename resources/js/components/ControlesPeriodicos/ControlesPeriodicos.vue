<template> 
    <div class="">
      
        <Buscar-component :find="filters" v-on:search="search" :RP="''"></Buscar-component>
        <div class="">

            <vuetable ref="vuetable"
                id="mytable"
                :fields="fields"
                :api-mode="false"
                :data="CPeriodicos"
                :show-sort-icons="false"
                :css="css.table"
                @vuetable:loaded="constr(CPeriodicos.data)"
                ><!--@vuetable:row-cell="onRowCLicked"-->
                
                <template slot="sucursal" slot-scope="props">
                    <div class="table-button-container">
                        {{props.rowData.sucursal.nombre}}
                    
                    </div>
                </template>
                <template slot="fecha" slot-scope="props">
                    <div class="table-button-container">
                        {{formatDate(props.rowData.fecha,false,4)}}
                    
                    </div>
                </template>
                <template slot="estado" slot-scope="props" >
                    <div class="table-button-container alert-table alert-danger">
                        {{estado(props.rowData.estado)}}
                    
                    </div>
                </template>
                <template slot="accion" slot-scope="props" >
                    <button type="button" class="btn btn-outline-success" data-toggle="modal"  data-target="#Modal-servicio-detalle" @click="onRowCLicked(props.rowData)">Abrir</button>
                </template>
            </vuetable>
            <br>
            <Comp-pagination  ref="pagination"
                :data="CPeriodicos"
                @click="pagination"
            >
            </Comp-pagination>
        </div>
        
        <detalle-controlesperiodicos :datos="controles_detalle" :idRP="idrp" :control="idrp.nrocontrol" ></detalle-controlesperiodicos>
        
    </div>
</template>
<script>

    import CssVuetable from '../StyleDataTable/DataTable_Nr';

export default {
    name:"Component-ControlesPeriodicos",
    props:[],
    data(){
      return {
        idrp:{id:'',nrocontrol:0},
        CPeriodicos:[],
        showModal:false,
        css:CssVuetable,
        controles_detalle:[],
        fields:[],
        filters: {
            url: "/home/Control-Periodicos/search",
            params: { 
                sucursal:'',
                Fdesde:'',
                Fhasta:'', 
            },
            data_select:{
                suc_select:[]
            },
            filters: [
                { span_text: "Sucursal", input_type: 'select' ,input_name: 'value' , data_select:'suc_select', select_model:"sucursal"},
                { span_text: "Desde", input_type: "date", input_name: "Fdesde" },
                { span_text: "Hasta", input_type: "date", input_name: "Fhasta" },
            ]
        },
      }
    },
    components: {
      
    },
    mounted(){

        this.show('/home/Control-Periodicos/data')
        this.select_branch();
    },
    methods: {
        constr(col){
            let c=0
            let field=[]
            let ColPuesto=''
            console.log('columnas controles periodicos')
            console.log(col)

    
             /* Columnas Automaticas */
            $.each(col, function (indexcol, valpuesto) { 
                 
                if (valpuesto){
                    ColPuesto=valpuesto.columnas
                }

            });
            $.each(ColPuesto, function (index, value) { 
                var item={}
                if (value.func=='row_type'){
                   item= {
                        'name':value.name,
                        'title':value.muestra,
                        'visible':value.visible,
                        formatter (value) {
                            return value.toUpperCase();
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
        show:function(page){
            try {
                
                axios.get(page)
                    .then(response => {
                        this.CPeriodicos=response.data
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
           
            this.show(url)
        },
        show_insp:function(id){
            try {
                axios.get('/home/Control-Periodicos/data/'+id)
                    .then(response => {
                        console.log(response.data)
                        this.controles_detalle=response.data
                        
                        
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        search:function(e){
               
                  this.CPeriodicos=e     
        },
        select_branch:function(){
            try {
            axios.get('/home/Sucursales/all')
                .then(response => {
                    var arr={};
                    $.each(response.data,function(key,element){
                       
                        arr[key]={'id':element.id,'value':element.nombre};
                    });
                    
                    this.filters.data_select.suc_select=arr;
                    
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        onRowCLicked (row){
            console.log(row)
            this.idrp.id=row.id
            this.idrp.nrocontrol=row.nrocontrol
            this.show_insp(row.id)
            this.showModal=true;
           
            $('#Modal-ControlPeriodico-detalle').show()
            $('#Modal-ControlPeriodico-detalle').toggleClass('show')
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
                return 'vigente'
            }else if(value==1){
                return 'vigente'
            }else if(value==2){
                return 'vigente'
            }
        }
    }
}
</script>