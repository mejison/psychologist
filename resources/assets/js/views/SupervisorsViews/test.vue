<template>
  <div id="app">
    <p>Welcome to your Vue.js app!</p>
 
    <dropzone id="upload" :options="dropzoneOptions">
    </dropzone>
 
  </div>
</template>
 
<script>
  
//   import Dropzone from 'vue2-dropzone';
  
  import Dropzone from 'nuxt-dropzone';
//   import 'nuxt-dropzone/dropzone.css';
 
  export default {
    name: 'MainApp',
    components: {
      Dropzone
    },
    data() {
        return {
            dropzoneOptions : {
                maxFilesize : 25,
                url : "https://httpbin.org/post"
            }
        };
    },
    methods: {
      showSuccess() {
        console.log('A file was successfully uploaded')
      }
    }
  }
</script>