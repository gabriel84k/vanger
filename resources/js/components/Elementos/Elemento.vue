<template> 
    <div class="">
        <div class="row">
            <div class="col-11">
                <Buscar-component :find="filters" v-on:search="search" :RP="''"></Buscar-component>
            </div>
            <div class="col-1 border-left">
                <button type="button" class="btn btn-outline-success"  @click="imprimirequipo(equipos)" 
                    style="font-size:9px"><i  class="fas fa-download"></i><label id="imprimeelementos"> Equipos</label></button>
            </div>

        </div>
        <br />
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
                class="shadow-lg mb-5 bg-white rounded"
                >
                <template slot="accion" slot-scope="props">
                    <button type="button" data-toggle="modal" 
                            data-target="#Modal-insp-detalle" 
                            class="btn btn-outline-success" 
                            @click="verelemento(props.rowData)" 
                            style="font-size:9px">Ver detalle...</button>
                
                </template>
                <template slot="fecha_fabricacion" slot-scope="props">
                    <div class="table-button-container">
                        {{ff(props.rowData.fecha_fabricacion)}}
                    
                    </div>
                </template>
                <template slot="vencimiento_carga" slot-scope="props">
                    <div class="table-button-container">
                        {{formatDate(props.rowData.vencimiento_carga,false,5)}}
                    
                    </div>
                </template>
                 <!-- Para el elemento Equipo -->
                <template slot="vencimiento_ph" slot-scope="props">
                    <div class="table-button-container">
                        {{formatDate(props.rowData.vencimiento_ph,false,5)}}
                    
                    </div>
                </template>
                <!-- Para el elemento Manguera -->
                <template slot="vencimientoDePH" slot-scope="props">
                    <div class="table-button-container">
                        {{formatDate(props.rowData.vencimientoDePH,false,5)}}
                    
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
            <DetalleElemento   :detalles="equipo_detalle" :datos="datos" :param="param"></DetalleElemento>
        </div>
    </div>
</template>
<script>
    
    import CssVuetable from '../StyleDataTable/DataTable_Nr';
    import DetalleElemento from './Elemento_Detalle';

export default {
    name:"Component-Equipos",
    props:['idelemento','arr','param','elemn'],
    data(){
      return { 
        filters:[],
        _estado:'',
        equipos:[],
        equipo_detalle:[],
        errored:false,
        loading:false,
        datos:[],
        showModal:0,
        css:CssVuetable,
        fields:[],
        filtersManguera: {
            url: "/home/Elementos/search/"+this.elemn+"/",
            params: { nanguera:'',
                    longitud:'',
                    diametro:'',
                    uniones:'',
                    lanza:'',
                    Fhasta:'',
                    boquilla:'',
                    estado:'' },
            data_select:{
                estado_select:[{id:'0',value:'todas'}]
            },
            filters: [
                { span_text: "N° Manguera", input_type: "text", input_name: "nanguera" },
                { span_text: "Longitud", input_type: "text", input_name: "longitud" },
                { span_text: "Diametro", input_type: "text", input_name: "diametro" },
                { span_text: "Uniones", input_type: "text", input_name: "uniones" },
                { span_text: "Lanza", input_type: "text", input_name: "lanza" },
                { span_text: "Boquilla", input_type: "text", input_name: "boquilla" },
                
                { span_text: "Estado", input_type: 'select' ,input_name: 'value' , data_select:'estado_select', select_model:"estado"},
            ]
        },
        filtersEquipo: {
            url: "/home/Elementos/search/"+this.elemn+"/",
            params: { nequipo:'',
                    sector:'',
                    marca:'',
                    codinterno:'',
                    Fdesde:'',
                    Fhasta:'',
                    agente:'',
                    estado:'',
                    capacidad:'',
                    sucursal:'' },
            data_select:{
                estado_select:[{id:'1',value:'Baja'},{id:'0',value:'Activo'}],
                sucursal:[{id:'0',value:'todas'}]
            },
            filters: [
                { span_text: "Nro. Extintor", input_type: "text", input_name: "nequipo" },
                { span_text: "Ubicación", input_type: "text", input_name: "sector" },
                { span_text: "Marca", input_type: "text", input_name: "marca" },
                { span_text: "Capacidad", input_type: "text", input_name: "capacidad" },
                { span_text: "Venc. desde", input_type: "date", input_name: "Fdesde", cita: "* Venc. Carga Desde" },
                { span_text: "Venc. hasta", input_type: "date", input_name: "Fhasta", cita: "* Venc. Carga Hasta" },
                { span_text: "Agente", input_type: "text", input_name: "agente" },
                { span_text: "Estado", input_type: 'select' ,input_name: 'value' , data_select:'estado_select', select_model:"estado"},
                { span_text: "Sucursal", input_type: 'select' ,input_name: 'value' , data_select:'sucursal', select_model:"sucursal"},
            ]
        },
        paginationData:[]
      }
    },
    components: {
        DetalleElemento
    },
    
    mounted(){
        
        if (this.idelemento>0){
            
            this.showDetalle(this.idelemento)
        }else{
            if(this.elemn==0){
                $("#imprimeelementos").text('Equipos')
                this.filters=this.filtersEquipo
                this.listasucursales()
            }else if(this.elemn==2){
                $("#imprimeelementos").text('Mangueras')
                this.filters=this.filtersManguera
                 this.listasucursales()
            }
            this.show('/home/Elementos/data',{tipo:this.elemn})
        }
    },
    methods: {
        listasucursales(){
            try {
                axios.get('/home/Sucursales/all')
                        .then(response => {
                            var element=[]
                            if (response.data){
                                response.data.forEach(item => {
                                    element.push({'id':item.id, 'value':item.nombre});
                                });
                               
                                this.filters.data_select.sucursal=element
                                console.log(this.filters.data_select.sucursal)
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
        fila_estado:function(dataItem,i){
            var Vph=this.fechavencimiento(dataItem.vencimiento_ph);
            var Vcarga=this.fechavencimiento(dataItem.vencimiento_carga);
            
            /* Empresa GroupTMaq [ pinta de rojo si la incidencia != "" ]*/
          
            if(Vph != undefined && Vcarga != undefined )
                if (dataItem.baja==0 && Vph==false && Vcarga==false){
                        return ''
                }else{
                        return 'alert alert-danger'
                }
            /*[Fin GroupTMaq]*/
        },
        showDetalle:function(idelemento){
                try {
                    
                    axios.get('/home/Elementos/data/'+idelemento)
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
        constr(col){
            let c=0
            let field=[]
      
            $.each(col, function (index, value) { 
                if (index=='diametro'){
                        /* Esto solo para manguera redondea el diametro con 2 decimales */
                        field[c++]={
                                'name':value.name,
                                'title':value.muestra,
                                'visible':value.visible,
                                formatter (value) {
                                    return  Number(value.toFixed(3))+ ' mm '  
                                
                                }
                            }
                }else if (index!='name'){
                            field[c++]={
                                        'name':value.name,
                                        'title':value.muestra,
                                        'visible':value.visible,
                                        
                                    }
                }
                
            });
            console.log(field)
            this.fields=field
        },
        show:function(page,params){
            try {
                
            axios.get(page,{params})
                    .then(response => {
                       
                        this.constr(response.data.data[0].columna)
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
            var params = this.filters.params;
           
            this.show(url,params)
        },
        verelemento (row){
           console.log(row)
            this.showModal=row.elemento_id;
            this.detalle(row,'?tipo='+this.elemn)
            $('#Modal-Equipo-detalle').modal('show')
            

        },
        detalle:function(data,param){
            try {
               
                axios.get('/home/Elementos/data/'+data.id+param)
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
            this.show_equipo(data.elemento_id)
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
        fechavencimiento(value){
           
            if (value != undefined){
                console.log('error split')
                console.log(value)

                var arr=value.split(' ')
                let date=arr[0].split('-')
                
                //let date=new Date(value)
                var año=parseInt(date[0]);
                var mes=parseInt(date[1]);

                let datehoy=new Date()
                var añohoy=parseInt(datehoy.getFullYear());
                var meshoy=parseInt(datehoy.getMonth()+1);
                
                if ((mes < meshoy && año <= añohoy) || (año < añohoy)){
                    return true
                }else{
                    return false
                }
            }
        },
        estado:function(value){
            if (value==0){
                this._estado='Activo';
                return 'alert-primary alert';

            }else{
                this._estado='Baja';
                return 'alert-danger alert';
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
        imprimirequipo(e){
            try {
                const params = new URLSearchParams();
                console.log(this.filters.params)
                $.each(this.filters.params, function(index,val) {
                    params.append(index,val)
                });
                params.append('pdf',true)
                var url = '/imprimir/Equipos/' + this.elemn +'?' +params
                window.open(url, '_blank');
               
                                    
            } catch (error) {
                console.log(error)
            }
        },

    }
}
</script>