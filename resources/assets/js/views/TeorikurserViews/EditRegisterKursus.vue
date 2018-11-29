<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row border-row">
            <div class="col-md-6">
                <h3>Edit Register course</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-wrapper pull-right">
                    <button type="submit" @click="redirectBack" class="btn btn-primary text-btn">
                        <img class="download" src="/image/left-arrow.png" alt="favorit" />
                        tilbage til søgning
                    </button>
                </div>
            </div>
        </div>

        <div class="row bio-row">
            <div class="col-md-12 data-info">
                <div class="bio-info-pro">
					<div class="col-xs-8">
						<ul>
							<li>Kursus: {{ course && course.course && course.course.course_name }}</li>
							<li>Dato: {{ course && course.date && course.date ? JSON.parse(course.date).join(', ') : "" }}</li>
							<li>Kursusnummer: {{ course && course.course &&course.course.course_number }}</li>
							<li>Timer: {{ course && course.course && course.course.course_hours }}</li>
							<li>Modul: {{ course && course.course && course.course.groups && course.course.groups.groups && course.course.groups.groups.name }}</li>
							<li>En laerer: <span v-if="course && course.course && course.course.teachers_all" v-for="t in course.course.teachers_all">{{ t.teacher_name }},</span></li>
						</ul>
					</div>
					<div class="col-xs-4">
						<div class="pull-right">
							<router-link :to="{ name : 'course.profile', params: { idCourse: course.course.user_id}}" style="color: #000"> 
								<button type="submit" class="btn btn-primary text-btn" style="margin-right: 5px;">
									<img style="padding: 0;" src="/image/link.png" alt="profile" />
								</button>
								<strong>Kursusindhold</strong>
							</router-link>
							
						</div>
					</div>
					
					<div class="col-md-12 form-group">
						<textarea class="form-control" v-model="course.comment"></textarea>
					</div>

					<div class="col-md-12">
						<button class="btn btn-success" @click="updateRegisterCourse()">Update</button>
					</div>

			        <div class="row register-supervisor-bilag">
			            <div class="col-md-12">
			                <h5>Bilag</h5>
		                    <hr class="line" />
		                    <div class="bilag-container">
			                    <div v-show="course.files && ! course.files.length">
			                    	Empty list !
			                    </div>
								<div v-for="f in course.files" v-show="course.files && course.files.length">
				                    <span class="container-img">
				                        <img src="/image/book.png" alt="book" />
				                    </span>
				                    <span>{{ f.name }}</span>
				                    <div class="actions">
				                        <a target="_blank" download :href="f.file ? 'storage/' + f.file.replace('public/', '') : f.dataUrl ? f.dataUrl : ''">
				                        	<img class="download" src="/image/arrow-download.png" alt="download" />
				                        </a>
				                        <a href="javascript:;" @click="deleteFile(f.id ? f.id : 0)">
				                        	<img class="trash" src="/image/vector-smart-trash.png" alt="delete" />
				                        </a>
				                    </div>
								</div>
								 <div class="row upload-bilag">
									<br />
									<input multiple="multiple"  type="file" id="uploadBilag" @change="selectFiles($event.target.files)" />
									<label for="uploadBilag" class="btn btn-primary-outline">Upload bilag</label>
								</div>
			                </div>
			            </div>
			        </div>
                </div>
            </div>
        </div>
    </article>
</template>
<script>
    export default {
        data()
        {
            return {
                course : []
            }
        },
        created : function () {
            this.getAllRegisterCourse();
        },
        methods : {
        	getAllRegisterCourse : function(){
        		let data = this;
	            axios.post('/getRegisterCourseInformation', {'id' : this.$route.params.idCourse})
	                .then(function (response) {
	                   data.course = response.data;
	                });
			},
			updateRegisterCourse : function()
			{
				let data = this;
            	axios.post('/updateRegisterCourse', {'id' : this.$route.params.idCourse, 'course' : this.course})
					.then(function (response) {
						setTimeout(function(){
							window.location.reload();
							data.getAllRegisterCourse(); 
						}, 1000);

					});
			},
        	deleteFile : function(id)
        	{
        		let data = this;
            	axios.post('/deleteFileRegisterCourse', {'id' : id})
					.then(function (response) {
						data.getAllRegisterCourse(); 
					});
        	},
    		redirectBack()
            {
                this.$router.back();
            },
			selectFiles : function(files)
			{
				let data = this;
				Array.prototype.forEach.call(files, function(file) { 
					var fr = new FileReader();
					fr.onloadend = function() {
						file.dataUrl = fr.result;
						data.course.files.push(file);
					}
					fr.readAsDataURL(file);					
				});
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
				data.course.files = tmp;
			}
        }
	}
</script>