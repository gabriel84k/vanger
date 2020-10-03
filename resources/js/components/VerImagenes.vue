<template>

    <div class="modal fade" id="exampleModal" tabindex="-9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header" :style="conf.imagen.styleheard">
                <h5 class="modal-title" id="exampleModalLabel">{{conf.imagen.titulo}}</h5>
                <button type="button" class="close" data-dismiss="" aria-label="Close" @click="close('#exampleModal')">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " :style="conf.imagen.stylemodal">
                <div :class="conf.imagen.classzoom">
               
                    <img :class="conf.imagen.classimg" :src="image" alt="Card image cap" :style="conf.imagen.styleimg">
                    <hr>
                    <div class="card-body">
                        <p class="card-text">{{desc}}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="" @click="close('#exampleModal')">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    const $ = require('jquery') //usamos jquery
    window.$ = $ //lo colocamos de forma global

export default {
    props:['image','desc','conf'],
    methods: {
        close(item){
            $(item).modal('hide')
            $(item).toggleClass('show')
        }
    },
}


</script>