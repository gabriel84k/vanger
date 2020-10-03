<template>
<div class="modal-body">
    <div class="m-widget1 col" >
        <div class="m-widget1__item">
            <div class="row m-row--no-padding align-items-center">
               
                <div class="col">
                    <h4 class="m-widget1__title AYN-tarjeta">{{Sector_detalle.Sectores[0].nombre}}</h4>
                    <span class="m-widget1__desc">Nombre del Sector</span>
                </div>
                <div class="col m--align-left">
                    <h4 class="m-widget1__title fecha-tarjeta">{{Sector_detalle.Sectores[0].sucursales_id}}</h4>
                    <span class="m-widget1__desc">Sucursal</span>
                </div>
                <div class="col m--align-left">
                    <h4 class="m-widget1__title fecha-tarjeta">{{Sector_detalle.Sectores[0].idsector}}</h4>
                    <span class="m-widget1__desc">Nro del Sector</span>
                </div>
                
            </div>
        </div>
        <hr>
    </div>
    <div class="card">
        <table class="table">
            <tbody>
                <div  v-for="p in Sector_detalle.Puestos" :key="p.id" class="btn-lg">
                    <th>Nro</th>
                    <th>Ubicación</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Equipo</th>
                    <th>Ubicación</th>
                    <th>Codigo de Control</th>
                    <tr>
                        <td >{{p.numero_puesto}}</td>
                        <td >{{p.ubicacion}}</td>
                        <td >{{p.equipo_tipo}}</td>
                        <td >{{p.capacidad}}</td>
                        <td >
                            <a data-toggle="collapse" href="#collapseExample">Ver equipos...</a>
                        </td>

                        <td >{{p.ubicacion}}</td>
                        <td >codigo control</td>
                    </tr>
                    <tr  v-for="sect in p.Equipos" :key="sect.id"> 
                        
                            <td class="collapse" id="collapseExample" colspan="7">
                                <div class="card card-body">
                                    <table class="table">
                                        <thead>
                                            <th>#</th>
                                            <th>Numero</th>
                                            <th>Sector</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <td>-</td>
                                            <td>{{sect.nro_equipo_evolution}}</td>
                                            <td>{{sect.tipo}}</td>
                                            <td><a :href="'/home/Equipos/detalle/'+p.equipos_id"  :key="p.equipos_id">Ver Equipo</a></td>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        
                    </tr>
                </div>
            </tbody>
            <tfoot>
                <tr>
                    <div class="col-md-12">
                        <a href="#">anterior</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">siguiente</a> 
                    </div>
                </tr>
            </tfoot>
        </table>
        <!--<Detalle-inspeccion :detalles="equipo_detalle"></Detalle-Inspeeccion>-->
    </div>
</div>
</template>
<script>
   
export default {
     name:"Componente-Sectores",
     props:['idsector'],
    data(){
      return {
        Sector:[],
        Sector_detalle:[],
        errored:false,
        loading:false,
      }
    },
    mounted(){
       this.detalle(this.idsector);
    },
    methods: {
       
        /*-[Obtiene el detalle del Inspecciones seleccionado]-*/
        detalle:function(id){
            try {
                axios.get('/home/Sectores/data/'+id)
                        .then(response => {
                            console.log(response.data)
                            this.Sector_detalle=response.data
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
                                    
                } catch (error) {
                    
                }
        },
       

    }
}
</script>