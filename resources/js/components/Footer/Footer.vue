<template>
    <footer v-show="visible" class="footer">
        <div v-show="visible" class="d-sm-flex justify-content-center justify-content-sm-between">
        
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0">
                <img :src="imgLougemedia.path" alt="" class="footerimg">
            </span>
        </div>
    </footer>
</template>
<script>
export default {
    props:["visible"],
    data() {
        return {
           
            imgLougemedia:{path:"/logo/Vanger/footer.jpeg"}, /* Vanger */
          
        }
    },
}
</script>