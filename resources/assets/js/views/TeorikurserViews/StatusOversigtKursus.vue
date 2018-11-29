<template>
  <div>
    <article class="content-block-profil content-block container-fluid">
        <div class="row">
            <h3>status for kurser: <span v-if="user && user.ps && user.ps.name">{{ user.ps.name }}</span></h3>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-7 block-value">
                <p class="text-center">REGISTRERET</p>
            </div>
            <div class="col-md-2 block-value">
                <p class="text-center">KRAV</p>
            </div>
          </div>
          <div class="row value-wrapper">
              <div class="col-md-7 block-value">
                  <p class="headline main-head">
                      <strong>Kurser</strong>
                  </p>
              </div>
              <div class="col-md-2 block-value">
                <p class="headline text-center">
                    <strong>{{ get_all_registers() }}</strong>
                </p>
              </div>
              <div class="col-md-2 block-value">
                <p class="headline text-center">
                    <strong>{{  get_all_hours() }}</strong>
                </p>
                </div>
            </div>
           <div class="row">
              <div class="col-md-11">
                  <div class="progress out-space">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                           aria-valuemin="0" aria-valuemax="100" :style="'width:' + Math.floor(get_all_registers() / get_all_hours() * 100) + '%'">
                          <strong>{{ Math.floor(get_all_registers() / get_all_hours() * 100) }}%</strong>  
                      </div>
                  </div>
              </div>

        </div>
          
        <br />

        <div class="require-wrapper">
            <!-- <p>Uddannelseinfo: <b v-for="r in requires_list">{{ r.course.name }}, </b></p> -->
            <p v-html="sp_text"></p>
        </div>            
    </article>
    <article class="content-block-profil content-block container-fluid">

        <div class="row"><h5>Status enkelt moduler</h5></div>
        <div v-for="g in groups">
            <div class="row">
                <div class="col-md-2 col-md-offset-7 block-value">
                    <p class="text-center">REGISTRERET</p>
                </div>
                <div class="col-md-2 block-value">
                    <p class="text-center">KRAV</p>
                </div>
          </div>
          <div class="row value-wrapper">
              <div class="col-md-7 block-value">
                  <p class="headline main-head">
                      <strong>{{ g.name }}</strong>
                  </p>
              </div>
              <div class="col-md-2 block-value">
                <p class="headline text-center">
                    <strong>{{ registers[g.id] ? registers[g.id] : 0 }}</strong>                        
                    
                </p>
              </div>
              <div class="col-md-2 block-value">
                <p class="headline text-center">
                    <strong>{{ g.hours }}</strong>
                </p>
                </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-11">
                        <div class="progress out-space">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                aria-valuemin="0" aria-valuemax="100" :style="'width:' + Math.floor((registers[g.id] ? registers[g.id] : 0) / g.hours * 100) + '%'">
                                <strong>{{ Math.floor((registers[g.id] ? registers[g.id] : 0) / g.hours * 100) }}%</strong>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             

            </div>
            <div class="row" v-if="g.show_sub">
                <div class="col-md-12">
                    <div v-for="s in g.sub">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7 block-value">
                                <p class="text-center">REGISTRERET</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center">KRAV</p>
                            </div>
                        </div> 
                        
                        <div class="row value-wrapper" style="background: linear-gradient(to right, #fff 0, #fff 15%, #f7f6f6 15%, #f7f6f6 100%);">
                            <div class="col-md-offset-2 col-md-5 block-value text-left">
                                <p class="headline main-head">
                                    <strong>{{ s.name }}</strong>
                                </p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="headline text-center">
                                    <strong>{{ s.id && sub_registers[s.id] ? sub_registers[s.id] : '0' }}</strong>                        
                                </p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="headline text-center">
                                    <strong>{{ s.hours }}</strong>
                                </p>
                            </div>                        
                        </div>
                        
                        <div class="col-md-offset-2 col-md-9" style="padding-right: 0;">
                            <div class="progress out-space" >
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width:' + Math.floor((sub_registers[s.id] ? sub_registers[s.id] : 0) / s.hours * 100) + '%'">
                                    <strong v-if="s.hours != 0">{{ Math.floor((sub_registers[s.id] ? sub_registers[s.id] : 0) / s.hours * 100) }}%</strong>  
                                    <strong v-if=" ! s.hours">0%</strong>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                       
                </div>
            </div>
        </div>
          
        </article>
         <br />
                        <br />
                        <br />
      </div>


</template>
<script>
    import Datepicker from 'vue-datepicker';
    
    export default {
        data()
        {
            return {
                groups : [],
                registers : {},
                sub_module : {},
                requires : {
                    groups : [],
                    sub : []
                },
                user : {},
                sp_text : '',
                requires_list : [],
            }
        },
        created : function () {
            this.getGroupsDashboard();
            this.getCurrentUser();

            let that = this;
            axios.get('/informationAboutUser')
                .then(function (response) {
                    that.sp_text = response.data.sp_text;
                    that.requires_list = response.data.requires;
                });
        },
        methods : {
            getCurrentUser() {
                let data = this;
                axios.get('/getUser')
                    .then(function (response) {
                        data.user = response.data;
                    });
            },
            get_all_hours() {
                var count = 0;
                for(var i in this.groups) {
                    count += this.groups[i].hours;
                }
                return count;
            },
            get_all_registers() {
                var count = 0;
                for(var i in this.registers) {
                    count += this.registers[i];
                }
                return count;
            },
            getGroupsDashboard() {
                let data = this;
                axios.post('/getDashbaordGroups', {})
                    .then(function (response) {
                        data.groups = response.data.gropus;
                        data.registers = response.data.registers;
                        data.sub_registers = response.data.sub_registers;

                        data.requires.groups = Object.values(response.data.requires.groups);
                        data.requires.sub = Object.values(response.data.requires.sub);
                    });
            }
        }
    }
</script>