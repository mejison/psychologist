<template>
  <div>
    <article class="content-block-profil content-block container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h3>Praksis Info: {{ user.ps.name }}</h3>
          <hr class="line">
        </div>
      </div>
      <div class="row">
        
        <div class="form-group"></div>

        <div class="col-md-offset-1 col-md-10">
          <p v-show="! edit" v-html="info.info">
          </p>
          
          <!-- <vue-editor v-show="edit" v-model="info.info" class="form-group"></vue-editor> -->

          <!-- <div class="pull-right">
            <button class="btn btn-primary" v-show=" ! edit" @click="edit = true">Edit</button>
            <button class="btn btn-success" v-show="edit" @click="updateInfoPsychologist()">Update</button>
          </div> -->
        </div>
      </div>
    </article>
  </div>
</template>
<script>
    
    import { VueEditor } from 'vue2-editor';

    export default {
        data()
        {
            return {
                info : "",
                edit : false,
                user : {}
            }
        },
        created : function () {
            this.getInfoPsychologist();
            
            let mainData = this;
            axios.get('/getUser')
              .then(function (response) {
                  mainData.user = response.data;
              });
        },
        methods : {
            getInfoPsychologist()
            {
                let mainInfo = this;
                axios.get('/getInfoPsychologist')
                        .then(function (response) {
                            mainInfo.info = response.data; 
                        });
            },
            updateInfoPsychologist()
            {
                let mainInfo = this;
                axios.post('/updateInfoPsychologist', { info : mainInfo.info.info })
                        .then(function (response) {
                            mainInfo.getInfoPsychologist();
                            mainInfo.edit = false;
                        });
            }
        },
        components: {
          VueEditor
        }
    }
</script>
