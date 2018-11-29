<template>
    <div class="container-fluid headline-row register-course">
        <div class="row">
            <div class="col-md-12 headline-block">
                <h3>REGISTRER TEORIKURSUS</h3>
                <hr class="line">
            </div>
        </div>
				<div class="row kursus">
						<div class="col-md-offset-1 col-md-6">
              <div class="row">
                <!-- <form class="register-search">
                  <div class="col-md-12">
                     <input readonly="readonly" :disabled="true" class="application-input search-field" v-model="date.time" type="text" placeholder="Dato"  />
                  </div>
                  <div class="col-md-12">
                    
                    <div class="search-wrapper">
                      <input readonly="readonly" list="courses" :disabled="true" class="application-input search-field disabled" type="text" placeholder="Kurser navn" v-model="searchField" @keyup="searchCourse()" />
                      <ul style="result-list" class="list-group result-list" v-show="courses != []"> 
                        <li class="list-group-item item" v-for="c in courses" @click="selectedCourseEvent(c)">
                          {{ c.course.course_name }}
                        </li>
                      </ul>
                    </div>

                  </div>
                </form> -->
                <div class="result-info" v-if="currentCourse">
                  <h3>{{ currentCourse && currentCourse.course && currentCourse.course.course_name }}</h3>
                  <p><b>Kursusnummer: </b>{{ currentCourse && currentCourse.course && currentCourse.course.course_number }}</p>
                  <p><b>Modul: </b> {{ currentCourse.course.groups.groups.name }}</p>
                  <p>
                    <b>Kursusdato: </b>
                      <span v-if="currentCourse && currentCourse.course && currentCourse.course.course_date" v-for="d in currentCourse.course.course_date">
                        <span :style="{'color' : d == date.time ? '#4BA3B6' : ''}">{{ d }}, </span>
                      </span>
                  </p>
                  <p><b>Timer: </b> {{ currentCourse.course.course_hours }}</p>
                  <p><b>Godkendt af DP: </b> {{ currentCourse.course.course_approved ? "ja" : "no" }}</p>
                  <p><b>Til specialistuddannelse: </b> 
                    <span v-if="currentCourse && currentCourse.user && currentCourse.user.full_info_about_user && currentCourse.user.full_info_about_user.special_preparation && JSON.parse(currentCourse.user.full_info_about_user.special_preparation)" v-for="sp in  currentCourse && currentCourse.user && currentCourse.user.full_info_about_user && currentCourse.user.full_info_about_user.special_preparation && JSON.parse(currentCourse.user.full_info_about_user.special_preparation)">{{ sp }}, </span>
                  </p>

                  <p>Undervisere: 
                    <span v-for="t in currentCourse.teachers" v-if="currentCourse.teachers.length">
                      {{ t.teacher_name }}, 
                    </span>
                    <span v-if=" ! currentCourse.teachers.length"> --- </span>
                  </p>
                </div>
              </div>
						</div>
				</div>
				<div class="row register-supervisor-textarea">
					<div class="col-md-offset-1 col-md-10">
            <textarea :disabled=" ! currentCourse" :class="{'has-error' : comment.length > config.max_comment_length }" :readonly=" ! currentCourse" name="SkrivKommentar" id="" cols="30" rows="1" v-model="comment" placeholder="Skriv kommentar..." ></textarea>
						<button type="submit" class="button light-green profil-button" @click="addRegisterCourse()">Gem</button>
					</div>
        </div>
        <div class="row register-supervisor-bilag">
          <div class="col-md-12">
            <h5>Bilag</h5>
            
            <hr class="line" />

            <div class="bilag-container" v-for="(f, index) in listAttach">
              <span>{{ f.name }}</span>
              <div class="actions">
                  <a href="javascript:;" @click="removeAttach(index)">
                    <img class="trash" src="/image/vector-smart-trash.png" alt="delete" />
                  </a>
              </div>
            </div>

            <div v-show=" ! listAttach.length" class="upload-bilag">
              Empty list !
            </div>

            <div class="row upload-bilag">
                <br />
                <input multiple="multiple" :disabled="! currentCourse" type="file" id="uploadBilag" @change="selectFiles($event.target.files)" />
                <label :disabled="! currentCourse" for="uploadBilag" class="btn btn-primary-outline">Upload bilag</label>
            </div>
          </div>
        </div>
    </div>
</template>
<script>
    
    import Datepicker from 'vue-datepicker';
    
    export default {
      data()
      {
        return {
          courses : [],
          selectedCourse : false,
          currentCourse : false,
          comment : "",
          searchField : "",
          listAttach : [],
          date: {
            time : ""
          },
          config : {
            max_comment_length : 1000
          },
          optionDatepicker : {
              type: 'multi-day',
              week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
              month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
              format: 'YYYY-MM-DD',
              placeholder: 'Dato',
              inputStyle: {
                  'appearance': 'none',
                  'background': 'transparent url("/image/down-arrow.svg") no-repeat',
                  'background-position': 'calc(100% - 20px)',
                  'width': '100%',
                  'height': '42px',
                  'border-radius': '5px',
                  'padding': '0 15px',
                  'font-family': 'Raleway',
                  'border': '1px solid #4ba3b6',
                  'color': '#4ba3b6',
                  'background-color': 'white',
              },
              color: {
                  header: '#3b7f8e',
                  headerText: '#000000'
              },
              buttons: {
                  ok: 'Ok',
                  cancel: 'Cancel'
              },
              overlayOpacity: 0.5,
              dismissible: true
          },
          files_list : []
        }
      },
      created : function () {
        let data = this;
        if (data.$route.params.idCourse)
        {
          axios.post('/getCourse', {id : data.$route.params.idCourse})
                    .then(function (response) {
                       data.currentCourse = response.data ? response.data : data.currentCourse;
                       data.searchField = data.currentCourse.course.course_name;
                       data.currentCourse.course.course_date = JSON.parse(data.currentCourse.course.course_date);
                       data.date.time = data.currentCourse.course.course_date ? JSON.stringify(data.currentCourse.course.course_date) : this.today();
                    });
        }
        data.changeDate();
      },
      methods : {
        searchCourse : function()
        {
          let data = this;
           axios.post('/findGlobalTeorikurser', {date : data.date.time, find : data.searchField})
                    .then(function (response) {
                      data.courses = data.slice(response.data, 5);
                    });
        },
        slice : function(list, to){
          var sliced = {},
              count = 0;
          for(var i in list)
          {
            if (count == to)
            {
              return sliced;
            }
             sliced[i] = list[i];
            count ++;
          }
          return sliced;
        },
        today : function() {
          var today = new Date(),
              dd = today.getDate() < 10 ? "0" + today.getDate() : today.getDate(),
              mm = (today.getMonth() + 1) < 10 ? "0" + (today.getMonth() + 1) : (today.getMonth() + 1),
              yyyy = today.getFullYear();

          return yyyy + '-' + mm + '-' + dd;
        },
        changeDate : function()
        {
          let data = this;
          axios.post('/getCourseAllByDate', {date : this.date.time})
            .then(function (response) {
                data.courses =  ! data.$route.params.idCourse ? response.data : [];
            });
        },
        selectFiles : function(files)
        {
          let data = this;
          
          Array.prototype.forEach.call(files, function(file) { 
              data.files_list.push(file);             
          });
          
          this.listAttach =  data.files_list;
        },
        removeAttach : function(index)
        {
          let data = this,
              tmp = [];

          Array.prototype.forEach.call(data.listAttach, function(file, row) { 
             if (row != index)
             {
                tmp.push(file);
             }
           });
          data.listAttach = tmp;
        },
        addRegisterCourse : function()
        {
          let data = this;
          if ( ! data.currentCourse)
          {
            swal("Warning", "Vælg venligst kursus!", "warning");
            return ;
          }

          if(data.comment.length < data.config.max_comment_length)
          {
            var fd = new FormData;
            for(var i in data.listAttach)
            {
              fd.append('files[]', data.listAttach[i]);
            }

            fd.append('course_id', data.currentCourse.course.id);
            fd.append('comment', data.comment);
            fd.append('date', data.date.time);

            axios.post('/addRegisterCourse', fd)
                    .then(function (response) {
                       swal({title :  response.data.title,  type : response.data.status}).then(function(){
                          if (response.data.status == 'success')
                          {
                            data.$router.push({name : "registreringerKursus"});
                          } 
                       })
                    }) 
          }
        },
        selectedCourseEvent : function(course)
        { 
          let data = this;
          if (course && course.course)
          {
            for(let i in data.courses) 
            {
              if (data.courses[i].course.id == course.course.id)
              { 
                data.currentCourse = data.courses[i];
                data.searchField =  data.currentCourse.course.course_name;
                data.courses = [];      
              }
            }
          }
          
        }
      },
       components: {
            'date-picker': Datepicker
        }
    }
</script>