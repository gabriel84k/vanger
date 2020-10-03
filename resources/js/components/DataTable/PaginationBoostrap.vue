<template>

  <nav>
    
    <ul class='pagination'>
      <li :class="['page-item', {'disabled': false}]" data-li='prev'>
        <a class="page-link" @click.prevent="loadPage('prev')">
          <span>&laquo;</span>
        </a>
      </li> 
      
      <template>
        
        <li v-for="n in totalPage" data-li='numeric' :key="n" :class="['page-item',{'ocultar':isCurrentPage(n)},{'active':isprimero(n)}]">
          <a class="page-link" @click.prevent="loadPage(n)" v-html="n"></a>
        </li>
      
      </template>
      
     
      <li :class="['page-item', {'disabled': false}]" data-li='next'>
        <a class="page-link" href="" @click.prevent="loadPage('next')">
          <span>&raquo;</span>
          
        </a>
      </li>
    </ul>  
  </nav>
</template>

<script>
//import VuetablePaginationMixin from "vuetable-2/src/components/VuetablePaginationMixin";

export default {
  
  el:'pagination',
  props:['data','vuepableid'],
  data(){
    return {
        totalpage:[],
        pagina:'',
       
    }
  },
  computed: {
      totalPage(){
           return this.data === null
                  ? 0
                  : this.data.last_page
      }
  },
  mounted(){
      
  },
  methods: {
    loadPage:function(page){
      switch (page) {
        case 'next':
              this.$emit('click',this.data.next_page_url,this.vuepableid)
              break;
         case 'prev':
              this.$emit('click', this.data.prev_page_url,this.vuepableid)
              break;
        default:
              this.$emit('click',this.data.path+'?page='+page,this.vuepableid)
              break;
      }
      
    },
    isCurrentPage (page) {
      if (page>10){return true}
    },
    isprimero(page){
      if(page ==1){return true}
    }
   
  },
};

$(document).ready(function(){
  var v_min=1;
  var v_max=10;
 
   
    

  $(document).on('load','.page-item',function(){
    alert('algo')
  })

  $(document).on('click','.page-item',function(){
    
    switch ($(this).data('li')) {
      case 'numeric':
        $('.page-item').removeClass('active')
        $(this).addClass('active')
        break;
      case 'prev':
        $.each($(this).parent().find('li'),function(i,v){
            if ($(v).hasClass('active')){
             
                if ($(v).prev().data('li')=='numeric'){  
                    $(v).prev().addClass('active')
                    $(v).removeClass('active')
                    if ($(v).prev().hasClass('ocultar')){
                        $(v).prev().removeClass('ocultar')
                        $(this).parent().find('li').eq((v_max+v_min)-1).addClass('ocultar')
                        v_max--
                    }
                    return false
                }else{
                    return false
                }
            }
          });
        
          break;
      case 'next':
        $.each($(this).parent().find('li'),function(i,v){
            if ($(v).next().data('li')=='numeric'){  
              if ($(v).hasClass('active')){
                  $(v).next().addClass('active')
                  if ($(v).next().hasClass('ocultar')){
                      $(v).next().removeClass('ocultar')
                      $(this).parent().find('li').eq(v_min).addClass('ocultar')
                      v_min++;
                      
                  }
                  $(v).removeClass('active')
                  return false
              }
              
            }else{
              return false
            }
        });
        break;
        
      
      
    }
  });
});
</script>
