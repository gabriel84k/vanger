<template> 
    <div class="">
        
        <Buscar-component :find="filters" v-on:search="search" :RP="''"></Buscar-component>
        
        <div class="">
            <vuetable ref="vuetable"
                :fields="fields"
                :api-mode="false"
                :row-class="fila_estado"
                :data="equipos"
                :show-sort-icons="true"
                :css="css.table"
                pagination-path=""
                id="mytable"
               
            
                >
                <template slot="accion" slot-scope="props">
                    <button type="button" data-toggle="modal" 
                            data-target="#Modal-insp-detalle" 
                            class="btn btn-outline-success" 
                            @click="verequipo(props.rowData)" 
                            style="font-size:9px">Ver detalle...</button>
                
                </template>
                <template slot="vencimiento_carga" slot-scope="props">
                    <div class="table-button-container">
                        {{formatDate(props.rowData.vencimiento_carga,false,4)}}
                    
                    </div>
                </template>
                <template slot="vencimiento_ph" slot-scope="props">
                    <div class="table-button-container">
                        {{formatDate(props.rowData.vencimiento_ph,false,4)}}
                    </div>
                </template>
                <template slot="baja" slot-scope="props" >
                    <div :class="'table-button-container ' +  estado(props.rowData.baja)">
                        {{_estado}}
                    </div>
                </template>
                
            </vuetable>
            <br>
            <Comp-pagination  ref="pagination"
                :vuepableid="'mytable'"
                :data="equipos"
                @click="pagination"
            >
            </Comp-pagination>
        </div>
        <div v-if="showModal!=0">
            <DetalleEquipo   :detalles="equipo_detalle" :datos="datos" :param="param"></DetalleEquipo>
        </div>
    </div>
</template>
<script>
    
    import CssVuetable from '../StyleDataTable/DataTable_Nr';
    import DetalleEquipo from './Equipo_Detalle'

export default {
    name:"Component-Equipos",
    props:['idequipo','arr','param'],
    data(){
      return {
        _estado:'',
        equipos:[],
        equipo_detalle:[],
        errored:false,
        loading:false,
        datos:[],
        showModal:0,
        css:CssVuetable,
        fields:[{
                name:'nro_equipo_evolution',
                title:'Número de equipo',
                titleClass: 'center aligned',
            },{
                name:'tipo',
                title:'Agente',
            },{
                name:'capacidad',
                title:'Cap.',
            },{
                name:'marca',
                title:'Marca',
            },{ 
                name:'puesto',
                title:'Puesto',
                visible:this.visualize('puesto'),
            },{
                name:'sector',
                title:'Sector',
                visible:this.visualize('sector'),
            },{
                name:'fecha_fabricacion',
                title:'Fecha fab.',
            },{
                name:'vencimiento_carga',
                title:'Vto. de Carga',
            },{
                name:'vencimiento_ph',
                title:'Vto. de PH',
            },{
                name:'baja',
                title:'Baja',
        }],
        filters: {
            url: "/home/Equipos/search",
            params: { nequipo:'',
                   
                    marca:'',
                    codinterno:'',
                    Fdesde:'',
                    Fhasta:'',
                    Ffabricacion:'',
                    estado:'' },
            data_select:{
                estado_select:[{id:'1',value:'Baja'},{id:'0',value:'Vigente'}]
            },
            filters: [
                { span_text: "Número de Equipo", input_type: "text", input_name: "nequipo" },
               
                { span_text: "Marca", input_type: "text", input_name: "marca" },
                
                { span_text: "Vencimiento desde", input_type: "date", input_name: "Fdesde" },
                { span_text: "Vencimiento hasta", input_type: "date", input_name: "Fhasta" },
                { span_text: "Fecha fab.", input_type: "number", input_name: "Ffabricacion" },
                { span_text: "Estado", input_type: 'select' ,input_name: 'value' , data_select:'estado_select', select_model:"estado"},
            ]
        },
        paginationData:[]
      }
    },
    components: {
        DetalleEquipo
    },
    
    mounted(){
      
        if (this.idequipo>0){
            this.showDetalle(this.idequipo)
        }else{
            this.show('/home/Equipos/data')
        }
    },
    methods: {
        fila_estado:function(dataItem,i){
            
            /* Empresa GroupTMaq [ pinta de rojo si la incidencia != "" ]*/
                if (dataItem.baja==0){
                        return ''
                }else{
                        return 'alert alert-danger'
                }
            /*[Fin GroupTMaq]*/
        },
        showDetalle:function(idequipo){
                try {
                    axios.get('/home/Equipos/data/'+idequipo)
                        .then(response => {
                            this.equipos=response.data
                            
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                    
                } catch (error) {
                    
                }
        },
        show:function(page,params){
            try {
                
            axios.get(page,{params})
                    .then(response => {
                        this.equipos=response.data
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
            //var params = this.filters.params;
           
            this.show(url)
        },
        verequipo (row){
           console.log(row)
            this.showModal=row.elemento_id;
            this.detalle(row.id)
            $('#Modal-Equipo-detalle').modal('show')
            

        },
        detalle:function(id){
            try {
                axios.get('/home/Equipos/data/'+id)
                        .then(response => {
                          
                            this.equipo_detalle=response.data
                           
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                    
            } catch (error) {
                
            }
            this.show_equipo(id)
        },
        search:function(e){
            this.equipos=e      
        },
        show_equipo:function(id){
            try {
                axios.get('/home/Inspecciones/Insp-Equipo/'+id)
                        .then(response => {
                            
                            if (response.data){
                                this.datos=response.data
                                                              
                            }
                            
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                
            } catch (error) {
                alert(error)
            }
        },
        formatDate:function(value,h,f){
            let date=new Date(value)
           
            var dia=String(date.getDate());
            var mes=String(date.getMonth()+1);

            (dia.length==1)?dia='0'+dia:dia;
            (mes.length==1)?mes='0'+mes:mes;

            if (h==true){
                var hora=String(date.getHours());
                var minuto=String(date.getMinutes());
                var segundo=String(date.getSeconds());
                (hora.length==1)?hora='0'+String(hora):hora;
                (minuto.length==1)?minuto='0'+String(minuto):minuto;
                (segundo.length==1)?segundo='0'+String(segundo):segundo;
                return dia + '/' + mes + '/' + date.getFullYear() +'  '+ hora +':'+ minuto +':'+ segundo;
            }else{
                if (f==2)
                    return mes + '/' + String(date.getFullYear()).substr(-2,2);
                else if(f==0)
                    return dia + '/' + mes + '/' + date.getFullYear();
                else if(f==4)
                    return  + mes + '/' + date.getFullYear();
                
            }

            
        },
        estado:function(value){
            if (value==0){
                this._estado='NO';
                return 'alert-primary';

            }else{
                this._estado='SI';
                return 'alert-danger';
            }
        }, 
        visualize(colum){
            
            switch (colum) {
                case 'puesto':
                    return this.param.Controles
                    break;

                case 'sector':
                    return this.param.Controles
                    break;

               
            }
        },


    }
}
</script>