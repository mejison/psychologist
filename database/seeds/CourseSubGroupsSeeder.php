<?php

use Illuminate\Database\Seeder;
use App\Models\ApplicationModels\CourseSubGroups;
use Illuminate\Support\Facades\DB;


class CourseSubGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseSubGroups::truncate();
        DB::statement("
            insert  into `course_sub_groups`(`id`,`groups_id`,`name`,`number`,`created_at`,`updated_at`) values 
            
            (2,'2','Voksenmodulet','10.0',NULL,NULL),
            
            (5,'4','Grundlagsteori og klinisk teori','12.4.4.2.2',NULL,'2017-10-17 10:33:59'),
            
            (6,'4','Klinisk psykologisk undersøgelsesmetodik','12.4.4.2.3',NULL,NULL),
            
            (7,'4','Anden teoretisk referenceramme (SubModule on Dashboard for “psykoterapi voksne”)','12.4.4.2.3',NULL,NULL),
            
            (8,'5','Grundlagsteori og klinisk teori','12.4.4.2.2.',NULL,NULL),
            
            (9,'5','Klinisk psykologisk undersøgelsesmetodik','12.4.4.2.1',NULL,NULL),
            
            (10,'5','Anden teoretisk referenceramme','12.4.4.2.3',NULL,NULL),
            
            (11,'6','Diagnostik og psykopatologi','13.4.4.2.1.',NULL,NULL),
            
            (12,'6','Klinisk psykologisk undersøgelsesmetodik','13.4.4.2.2.',NULL,NULL),
            
            (13,'6','Behandling','13.4.4.2.3.',NULL,NULL),
            
            (14,'6','Psykiatrilov','13.4.4.2.4.',NULL,NULL),
            
            (15,'6','Psykiatriens organisering, ledelse administration, kvalitetssikring og drift','13.4.4.2.5.',NULL,NULL),
            
            (16,'7','Diagnostik og psykopatologi','6.4.4.2.1.',NULL,NULL),
            
            (17,'7','Psykologiske undersøgelsesmetoder','6.4.4.2.2.',NULL,NULL),
            
            (18,'7','Psykoterapeutiske metoder ','6.4.4.2.3.',NULL,NULL),
            
            (19,'8','Almen gerontopsykologi','16.4.4.2.1.',NULL,NULL),
            
            (20,'8','Klinisk gerontopsykologi','16.4.4.2.2.',NULL,NULL),
            
            (21,'8','Relevante valgfrie kursusaktiviteter','16.4.4.2.3.',NULL,NULL),
            
            (22,'9','Neuropsykologiske forstyrrelser','15.4.4.2.1.',NULL,NULL),
            
            (23,'9','Rehabilitering','15.4.4.2.2.',NULL,NULL),
            
            (24,'9','Sygdomslære','15.4.4.2.3.',NULL,NULL),
            
            (25,'9','Udvidet kursus i klinisk neuroanatomi, neurofysiologi, neurokemi','15.4.4.2.3.',NULL,NULL),
            
            (26,'9','Valfrie kursusdage','15.4.4.2.5.',NULL,NULL),
            
            (27,'10','Psykotraumatologisk teori; hovedområde/paradigmer','14.4.4.2.1',NULL,NULL),
            
            (28,'10','Interventionsdel','14.4.4.2.2.',NULL,NULL),
            
            (29,'10','Erklæringsudformning','14.4.4.2.3',NULL,NULL),
            
            (30,'10','Valgfri del','14.4.4.2.4.',NULL,NULL),
            
            (43,'13','Generel klinisk viden inden for det sundhedspsykologiske område ','11.4.4.2.1.',NULL,NULL),
            
            (44,'13','Intervention i det kliniske arbejde','11.4.4.2.2.',NULL,NULL),
            
            (45,'13','Pædagogisk sundhedspsykologi ','11.4.4.2.3. ',NULL,NULL),
            
            (46,'13','Sundhedspsykologi, organisation og samfund','11.4.4.2.4.',NULL,NULL),
            
            (47,'13',' Øvrige kurser under et eller to af ovenstående i de resterende 22 timer','11.4.4.2.5',NULL,NULL),
            
            (48,'2','Børnemodulet','5.0','2017-10-16 13:57:03','2017-10-16 13:57:03'),
            
            (49,'2','Arbejds- og organisationspsykologimodulet','17.0','2017-10-16 13:57:09','2017-10-16 13:57:09'),
            
            (51,'1','Gå til kurser','','2017-10-16 17:01:04','2017-10-16 17:01:04'),
            
            (53,'3','Gå til kurser','','2017-10-16 17:03:39','2017-10-16 17:03:39'),
            
            (54,'11','Personligt udviklingsarbejde','18.4.4.2.1.','2017-10-16 17:35:09','2017-10-16 17:35:09'),
            
            (55,'11','Den teoretiske del af grundstammen','18.4.4.2.2.','2017-10-16 17:35:25','2017-10-16 17:35:25'),
            
            (56,'11','Supervision (i grupper)','18.4.4.2.3.','2017-10-16 17:35:40','2017-10-16 17:35:40'),
            
            (57,'11','Casestudie','18.4.4.2.4','2017-10-16 17:35:54','2017-10-16 17:35:54'),
            
            (58,'11','Formidling','18.4.4.2.5.','2017-10-16 17:36:10','2017-10-16 17:36:10'),
            
            (60,'11','Øvrige teorikurser','18.4.4.2.6.','2017-10-16 17:39:28','2017-10-16 17:39:28'),
            
            (61,'12','Udviklings-, lærings- og organisationsteorier','8.4.4.2.1','2017-10-16 17:41:35','2017-10-16 17:41:35'),
            
            (62,'12','Ændringsprocesser i organisationer/organisationsudvikling','8.4.4.2.2.','2017-10-16 17:41:51','2017-10-16 17:41:51'),
            
            (63,'20','Udvikling i neuropsykologisk perspektiv','7.4.4.2.1','2017-10-16 17:49:42','2017-10-16 17:49:42'),
            
            (64,'20','Neuropsykologiske funktionsforstyrrelser','7.4.4.2.2','2017-10-16 17:49:57','2017-10-16 17:49:57'),
            
            (65,'20','Udredningsprocedurer','7.4.4.2.3','2017-10-16 17:50:10','2017-10-16 17:50:10'),
            
            (66,'20','Intervention','7.4.4.2.4.','2017-10-16 17:50:23','2017-10-16 17:50:23'),
            
            (67,'21','Generel klinisk viden inden for det sundhedspsykologiske område','11.4.4.2.1.','2017-10-16 17:53:53','2017-10-16 17:53:53'),
            
            (68,'21','Intervention i det kliniske arbejde','11.4.4.2.2.','2017-10-16 17:54:12','2017-10-16 17:54:12'),
            
            (70,'21','Pædagogisk sundhedspsykologi','11.4.4.2.3.','2017-10-16 17:54:31','2017-10-16 17:54:31'),
            
            (71,'21','Sundhedspsykologi, organisation og samfund','11.4.4.2.4.','2017-10-16 17:54:44','2017-10-16 17:54:44'),
            
            (72,'21','Øvrige kurser under et eller to af ovenstående i de resterende 22 timer','11.4.4.2.5','2017-10-16 17:54:58','2017-10-16 17:54:58');
        ");
    }
}
