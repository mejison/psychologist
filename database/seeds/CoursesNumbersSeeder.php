<?php

use Illuminate\Database\Seeder;
use App\Models\ApplicationModels\CourseNumber;
use Illuminate\Support\Facades\DB;

class CoursesNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseNumber::truncate();
        DB::statement("
        insert  into `course_numbers`(`id`,`groups_id`,`number`,`name`,`time`,`comment`,`created_at`,`updated_at`) values 
        
        (31,1,'.4.1','Teori om forskningsmetode',18,'','2017-10-16 13:52:47','2017-10-16 13:52:47'),
        
        (32,1,'.4.2','Skriftligt produkt, godkendt',42,'','2017-10-16 13:53:02','2017-10-16 13:53:02'),
        
        (33,2,'10.2','Assessment - Systematisk klinisk udredning og vurdering - Del 1',6,'','2017-10-16 13:53:26','2017-10-17 09:20:54'),
        
        (34,2,'10.2','Assessment - Systematisk klinisk udredning og vurdering - Del II',18,'','2017-10-16 13:53:35','2017-10-17 09:21:00'),
        
        (35,2,'10.2','Assessment - Systematisk klinisk udredning og vurdering - Del III',24,'','2017-10-16 13:53:47','2017-10-17 09:21:05'),
        
        (36,2,'10.2','Assessment - Systematisk klinisk udredning og vurdering',48,'','2017-10-16 13:53:56','2017-10-17 09:21:12'),
        
        (37,2,'10.2','Assessment',24,'','2017-10-16 13:54:07','2017-10-17 09:21:19'),
        
        (38,2,'10.3','Differentialdiagnostik',24,'','2017-10-16 13:54:19','2017-10-17 09:21:25'),
        
        (39,2,'10.4','Personlighedsforstyrrelser og personlighedsteori',18,'','2017-10-16 13:54:30','2017-10-17 09:21:31'),
        
        (40,2,'10.5','Valg af interventionsformer, voksne',12,'','2017-10-16 13:54:40','2017-10-17 09:21:38'),
        
        (41,2,'10.5','Psykoterapeutisk behandling,',12,'','2017-10-16 13:54:49','2017-10-17 09:21:47'),
        
        (42,2,'10.6','Lovgivning og etik, voksne',12,'','2017-10-16 13:54:58','2017-10-17 09:21:53'),
        
        (43,2,'10.6','Lovgivning og etik i relation til psykologarbejde inden for voksenområdet',12,'','2017-10-16 13:55:05','2017-10-17 09:21:59'),
        
        (44,3,'.5.2','Barnets psykiske udvikling og udviklingsforstyrrelser',30,'','2017-10-16 13:55:23','2017-10-16 13:55:23'),
        
        (45,3,'.5.3','Psykologisk udredning',36,'','2017-10-16 13:55:39','2017-10-16 13:55:39'),
        
        (46,3,'.5.3','Den psykologiske undersøgelse',36,'','2017-10-16 13:55:50','2017-10-16 13:55:50'),
        
        (47,3,'.5.4','Valg af interventionsformer, børn og unge',12,'','2017-10-16 13:56:00','2017-10-16 13:56:00'),
        
        (48,3,'.5.5','Lovgivning og etik i relation til psykologarbejde inden for børne- og ungeområdet',12,'','2017-10-16 13:56:07','2017-10-16 13:56:07'),
        
        (49,48,'5.2','Barnets psykiske udvikling og udviklingsforstyrrelser',30,'','2017-10-16 14:07:28','2017-10-17 09:27:07'),
        
        (50,48,'5.3','Psykologisk udredning',36,'','2017-10-16 14:07:47','2017-10-17 09:27:12'),
        
        (51,48,'5.3','Den psykologiske undersøgelse',36,'','2017-10-16 14:08:03','2017-10-17 09:27:17'),
        
        (52,48,'5.4','Valg af interventionsformer, børn og unge',12,'','2017-10-16 14:08:24','2017-10-17 09:27:25'),
        
        (53,48,'5.5','Lovgivning og etik i relation til psykologarbejde inden for børne- og ungeområdet',12,'','2017-10-16 14:08:36','2017-10-17 09:27:30'),
        
        (54,49,'17.2','Metode til kortlæøgning og diagnostik',18,'','2017-10-16 14:08:54','2017-10-17 10:27:22'),
        
        (55,49,'17.2','Med individet i fokus',30,'','2017-10-16 14:09:08','2017-10-17 10:27:29'),
        
        (56,49,'17.3','Med gruppen i fokus',30,'','2017-10-16 14:09:23','2017-10-17 10:27:37'),
        
        (57,49,'17.3','Samspillet mellem spektret af konsulentroller',24,'','2017-10-16 14:09:40','2017-10-17 10:27:42'),
        
        (58,49,'17.4','Med Organisationen i fokus',30,'','2017-10-16 14:10:01','2017-10-17 10:27:47'),
        
        (59,49,'17.4','Organisationsanalyse',24,'','2017-10-16 14:10:21','2017-10-17 10:27:53'),
        
        (60,49,'17.5','Intervention i grupper og organisationer',18,'','2017-10-16 14:10:35','2017-10-17 10:27:58'),
        
        (61,49,'17.6','Nyere stressfænomener og ændringer i work-life-balancen',12,'','2017-10-16 14:10:48','2017-10-17 10:28:03'),
        
        (62,49,'17.7','Arbejdets betydning og det rummelige arbejdsmarked',12,'','2017-10-16 14:11:05','2017-10-17 10:28:10'),
        
        (63,49,'17.8','Arbejdet i og med andre faglige og etniske kulturer',12,'','2017-10-16 14:11:28','2017-10-17 10:28:22'),
        
        (64,47,'3.99.,','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 14:13:02','2017-10-16 14:13:02'),
        
        (65,47,'3.99.,','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 14:13:17','2017-10-16 14:13:17'),
        
        (66,44,'11.4.4.2.2.','Introduktion til Intensiv Dynamisk Korttidsterapi',12,'','2017-10-16 14:13:40','2017-10-16 14:13:40'),
        
        (67,43,'11.4.4.2.1.','MDI og Hamilton - diagnosticering og måling af sværhedsgrad af depression',6,'','2017-10-16 14:13:57','2017-10-16 14:13:57'),
        
        (68,42,'7.4.4.2.4.','Socio-emotionelle kompetencer hos børn - teori og praksis',3,'','2017-10-16 14:14:18','2017-10-16 14:14:18'),
        
        (69,41,'7.4.4.2.3.','Socio-emotionelle kompetencer hos børn - teori og praksis',3,'','2017-10-16 14:14:46','2017-10-16 14:14:46'),
        
        (70,6,'12.4.4.2.1.','Exners Rorschach System, grundkursus (voksne) - kursustype I',18,'','2017-10-16 14:27:29','2017-10-16 14:27:29'),
        
        (71,6,'12.4.4.2.1.','Exners Rorschach System, videregående (voksne)- kursustype II',12,'','2017-10-16 14:27:54','2017-10-16 14:27:54'),
        
        (72,6,'12.4.4.2.1.','TAT i et nyt perspektiv',18,'','2017-10-16 14:28:08','2017-10-16 14:28:08'),
        
        (73,6,'12.4.4.2.1.','MDI og Hamilton - diagnosticering og måling af sværhedsgrad af depression',6,'','2017-10-16 14:28:20','2017-10-16 14:28:20'),
        
        (74,7,'12.4.4.2.3.','Introduktion til Intensiv Dynamisk Korttidsterapi',30,'','2017-10-16 14:28:36','2017-10-16 14:28:36'),
        
        (75,7,'12.4.4.2.3.','Kognitiv adfærdsterapi ved personlighedsforstyrrelser og tidlige traumer',30,'','2017-10-16 14:28:50','2017-10-16 14:28:50'),
        
        (76,7,'3.99..','Socio-emotionelle kompetencer hos børn - teori og praksis',12,'','2017-10-16 14:29:04','2017-10-16 14:29:04'),
        
        (77,7,'3.99.,','Parenting in relation to children\'s social-emotional development and resilience in early childhood',6,'','2017-10-16 14:29:18','2017-10-16 14:29:18'),
        
        (78,7,'3.99.,','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 14:29:30','2017-10-16 14:29:30'),
        
        (80,7,'3.99.,','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 14:29:53','2017-10-16 14:29:53'),
        
        (81,9,'12.4.4.2.1.','Exners Rorschach System, grundkursus (børn) - kursustype I',18,'','2017-10-16 14:33:03','2017-10-16 14:33:03'),
        
        (82,9,'12.4.4.2.1.','Exners Rorschach System, videregående (børn) - kursustype II',12,'','2017-10-16 14:33:17','2017-10-16 14:33:17'),
        
        (83,9,'.12.4.2','Exners Rorschach System, videregående (børn) - kursustype II',18,'','2017-10-16 14:33:29','2017-10-16 14:33:29'),
        
        (84,9,'12.4.4.2.1.','TAT i et nyt perspektiv',18,'','2017-10-16 14:33:41','2017-10-16 14:33:41'),
        
        (85,9,'12.4.4.2.1.','Undersøgelse af eksekutive funktioner hos børn og unge særlig med vægt på BRIEF og D-KEFS',12,'','2017-10-16 14:33:52','2017-10-16 14:33:52'),
        
        (86,10,'3.99..','Socio-emotionelle kompetencer hos børn - teori og praksis',12,'','2017-10-16 14:34:10','2017-10-16 14:34:10'),
        
        (87,10,'3.99.,','Parenting in relation to children\'s social-emotional development and resilience in early childhood',6,'','2017-10-16 14:34:30','2017-10-16 14:34:30'),
        
        (88,11,'13.4.4.2.1.','MDI og Hamilton - diagnosticering og måling af sværhedsgrad af depression',6,'','2017-10-16 14:35:25','2017-10-16 14:35:25'),
        
        (89,12,'13.4.4.2.2.','Exners Rorschach System, grundkursus (voksne) - kursustype I',18,'','2017-10-16 14:36:34','2017-10-16 14:36:34'),
        
        (90,12,'13.4.4.2.2.','Exners Rorschach System, videregående (voksne)- kursustype II',12,'','2017-10-16 14:37:08','2017-10-16 14:37:08'),
        
        (91,12,'13.4.4.2.2.','TAT i et nyt perspektiv',18,'','2017-10-16 14:37:33','2017-10-16 14:37:33'),
        
        (92,12,'13.4.4.2.2.','Forældrekompetence- undersøgelser',12,'','2017-10-16 14:37:46','2017-10-16 14:37:46'),
        
        (93,12,'13.4.4.2.2.','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 14:38:02','2017-10-16 14:38:02'),
        
        (94,12,'13.4.4.2.2.','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 14:38:15','2017-10-16 14:38:15'),
        
        (95,13,'13.4.4.2.3.','Feedback-Informed Treatment (FIT)',6,'','2017-10-16 14:38:30','2017-10-16 14:38:30'),
        
        (96,13,'13.4.4.2.6.2.','Kognitiv adfærdsterapi ved personlighedsforstyrrelser og tidlige traumer',12,'','2017-10-16 14:38:41','2017-10-16 14:38:41'),
        
        (97,13,'13.4.4.2.3.','Introduktion til Intensiv Dynamisk Korttidsterapi',18,'','2017-10-16 14:38:52','2017-10-16 14:38:52'),
        
        (98,16,'6.4.4.2.1.','Socio-emotionelle kompetencer hos børn - teori og praksis',6,'','2017-10-16 14:39:20','2017-10-16 14:39:20'),
        
        (99,16,'6.4.4.2.1.','Parenting in relation to children\'s social-emotional development and resilience in early childhood',6,'','2017-10-16 14:39:32','2017-10-16 14:39:32'),
        
        (100,16,' 6.4.2.','Exners Rorschach System, videregående (børn) - kursustype II',18,'','2017-10-16 14:39:45','2017-10-16 14:39:45'),
        
        (101,17,'6.4.4.2.2.','Socio-emotionelle kompetencer hos børn - teori og praksis',6,'','2017-10-16 14:40:29','2017-10-16 14:40:29'),
        
        (102,17,'6.4.4.2.2.','TAT i et nyt perspektiv',18,'','2017-10-16 14:40:41','2017-10-16 14:40:41'),
        
        (103,17,'6.4.4.2.2.','Exners Rorschach System, grundkursus (børn) - kursustype I',18,'','2017-10-16 14:40:56','2017-10-16 14:40:56'),
        
        (104,17,'6.4.4.2.2','Exners Rorschach System, videregående (børn) - kursustype II',12,'','2017-10-16 14:41:11','2017-10-16 14:41:11'),
        
        (105,17,' 6.4.2.','Exners Rorschach System, videregående (børn) - kursustype II',18,'','2017-10-16 14:41:26','2017-10-16 14:41:26'),
        
        (106,17,'6.4.4.2.2.','MDI og Hamilton - diagnosticering og måling af sværhedsgrad af depression',6,'','2017-10-16 14:41:42','2017-10-16 14:41:42'),
        
        (107,17,'6.4.4.2.2.','Forældrekompetence- undersøgelser',12,'','2017-10-16 14:41:54','2017-10-16 14:41:54'),
        
        (108,17,'6.4.4.2.2.','Undersøgelse af eksekutive funktioner hos børn og unge særlig med vægt på BRIEF og D-KEFS',12,'','2017-10-16 14:42:09','2017-10-16 14:42:09'),
        
        (109,18,'6.4.4.2.3.','Feedback-Informed Treatment (FIT)',6,'','2017-10-16 14:42:27','2017-10-16 14:42:27'),
        
        (110,20,'16.4.4.2.2.1.','Psykopatologiske/psykiatriske syndromer hos ældre',24,'','2017-10-16 14:43:04','2017-10-16 14:43:04'),
        
        (111,20,'16.4.4.2.2.2.','Geriatri og farmakologi for gerontopsykologer',24,'','2017-10-16 14:43:17','2017-10-16 14:43:17'),
        
        (112,20,'16.4.4.2.2.3.','Intervention',48,'','2017-10-16 14:43:29','2017-10-16 14:43:29'),
        
        (113,20,'16.4.4.2.2.3','Psykologisk behandlings-/støttetilbud til pårørende til mennesker med demens',12,'','2017-10-16 14:43:41','2017-10-16 14:43:41'),
        
        (114,21,'3.99','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 14:43:59','2017-10-17 10:36:50'),
        
        (115,21,'3.99','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 14:44:16','2017-10-17 10:36:55'),
        
        (117,51,'4.1','Teori om forskningsmetode',18,'','2017-10-16 17:01:48','2017-10-17 09:20:18'),
        
        (118,51,'4.2','Skriftligt produkt, godkendt',42,'','2017-10-16 17:02:25','2017-10-17 09:20:25'),
        
        (119,53,'3.1','Praktisk organisationspsykologi',24,'','2017-10-16 17:04:10','2017-10-17 10:28:44'),
        
        (120,53,'3.2','Organisationspsykologi',12,'','2017-10-16 17:04:35','2017-10-17 10:28:48'),
        
        (121,53,'3.3','Sorg og krise hos børn',12,'','2017-10-16 17:04:52','2017-10-17 10:28:53'),
        
        (122,53,'3.4','Naturlige og komplicerede sorgreaktioner ved tab hos voksne',12,'','2017-10-16 17:05:55','2017-10-17 10:28:58'),
        
        (123,53,'3.4','Sorg og krise hos voksne',12,'','2017-10-16 17:06:18','2017-10-17 10:29:03'),
        
        (124,53,'3.5','Angst og depression',12,'','2017-10-16 17:06:44','2017-10-17 10:29:09'),
        
        (125,53,'3.5','Angst og depression i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 17:07:01','2017-10-17 10:29:18'),
        
        (128,53,'3.6','Klinisk sexologi',12,'','2017-10-16 17:07:54','2017-10-17 10:29:24'),
        
        (129,53,'3.7','Neuropsykologiske tilstande, børn',12,'','2017-10-16 17:08:14','2017-10-17 10:29:30'),
        
        (130,53,'3.7','Neuropsykologiske tilstande, voksne',12,'','2017-10-16 17:08:36','2017-10-17 10:29:36'),
        
        (131,53,'3.8','Fokus på apopleksi, kranietraumer og demens',12,'','2017-10-16 17:08:56','2017-10-17 10:29:41'),
        
        (132,53,'3.9','Demensudredning',12,'','2017-10-16 17:09:14','2017-10-17 10:29:47'),
        
        (133,53,'3.10','Psykofarmakologi, børn og unge',12,'','2017-10-16 17:09:49','2017-10-17 10:29:56'),
        
        (134,53,'3.10','Psykofarmakologi, voksne',12,'','2017-10-16 17:10:15','2017-10-17 10:30:03'),
        
        (135,53,'3.11','Funktionel neuroanatomi/human neurobiologi',24,'','2017-10-16 17:10:41','2017-10-17 10:30:09'),
        
        (136,53,'3.12','Neurokemi',12,'','2017-10-16 17:11:05','2017-10-17 10:30:14'),
        
        (137,53,'3.13','Billeddannelsesteknikker',12,'','2017-10-16 17:11:30','2017-10-17 10:30:20'),
        
        (138,53,'3.14','Psyke og soma',12,'','2017-10-16 17:11:44','2017-10-17 10:30:26'),
        
        (139,53,'3.15','Familieterapi: teori og intervention, I',12,'','2017-10-16 17:12:06','2017-10-17 10:30:30'),
        
        (140,53,'3.16','Familieterapi: teori og intervention II ',12,'','2017-10-16 17:12:23','2017-10-17 10:30:36'),
        
        (141,53,'3.17','Psykologen som konsulent',12,'','2017-10-16 17:12:41','2017-10-17 10:30:41'),
        
        (142,53,'3.18','Konsultativ tilgang til konflikthåndtering',24,'','2017-10-16 17:12:57','2017-10-17 10:30:47'),
        
        (143,53,'3.19','Transkulturel psykologi',18,'','2017-10-16 17:13:22','2017-10-17 10:30:55'),
        
        (144,53,'3.20','Supervision af andre faggrupper',12,'','2017-10-16 17:13:46','2017-10-17 10:31:04'),
        
        (145,53,'3.21','Ledelse og organisation',12,'','2017-10-16 17:14:04','2017-10-17 10:31:10'),
        
        (146,53,'3.99','Den mandlige klient i teori og i din praksis',18,'','2017-10-16 17:14:23','2017-10-17 10:31:18'),
        
        (147,53,'3.99','Psykologisk behandling af problematisk vrede hos voksne',18,'','2017-10-16 17:14:39','2017-10-17 10:31:27'),
        
        (148,53,'3.99','Stress - en psykologisk forståelse',12,'','2017-10-16 17:14:58','2017-10-17 10:31:32'),
        
        (149,53,'3.99','Supervision af andre faggrupper, II - Metodisk og dialogisk fokus for din praksis',12,'','2017-10-16 17:15:20','2017-10-17 10:31:37'),
        
        (150,53,'3.99','Undervisningspædagogik',12,'','2017-10-16 17:15:39','2017-10-17 10:31:43'),
        
        (151,53,'3.99','Psykologisk behandlings-/støttetilbud til pårørende til mennesker med demens',6,'','2017-10-16 17:15:59','2017-10-17 10:31:53'),
        
        (152,23,'15.4.4.2.2.','Psykologisk behandlings-/støttetilbud til pårørende til mennesker med demens',6,'','2017-10-16 17:25:02','2017-10-16 17:25:02'),
        
        (153,26,'3.99.,','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 17:26:03','2017-10-16 17:26:03'),
        
        (154,26,'3.99.,','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 17:26:18','2017-10-16 17:26:18'),
        
        (155,28,'14.4.4.2.2.1','Intervention på individuelt plan i relation til akutte traumer',12,'','2017-10-16 17:27:23','2017-10-16 17:27:23'),
        
        (156,28,'14.4.4.2.2.2','Intervention på individuelt plan i relation til længerevarende og kroniske smerter',12,'','2017-10-16 17:27:41','2017-10-16 17:27:41'),
        
        (157,28,'14.4.4.2.2.2.','Introduktion til Intensiv Dynamisk Korttidsterapi',12,'','2017-10-16 17:28:03','2017-10-16 17:28:03'),
        
        (158,28,'14.4.4.2.2.3.','Intervention i gruppe i relation til traumatiske hændelser',12,'','2017-10-16 17:28:18','2017-10-16 17:28:18'),
        
        (159,28,'14.4.4.2.2.4.','Krisestyring',12,'','2017-10-16 17:28:42','2017-10-16 17:28:42'),
        
        (160,28,' 3.99.','Feedback-Informed Treatment (FIT)',6,'','2017-10-16 17:29:06','2017-10-16 17:29:06'),
        
        (161,30,'14.4.4.2.4.','Feedback-Informed Treatment (FIT)',6,'','2017-10-16 17:30:00','2017-10-16 17:30:00'),
        
        (162,30,'3.99.,','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 17:30:14','2017-10-16 17:30:14'),
        
        (163,30,'3.99.,','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 17:30:33','2017-10-16 17:30:33'),
        
        (164,55,'18.4.4.2.','Organisation for organisationspsykologer',18,'','2017-10-16 17:37:12','2017-10-16 17:37:12'),
        
        (165,61,'8.4.4.2.1.','Feedback-Informed Treatment (FIT)',6,'','2017-10-16 17:42:14','2017-10-16 17:42:14'),
        
        (166,61,'8.4.4.2.1','Forældrekompetence- undersøgelser',12,'','2017-10-16 17:42:34','2017-10-16 17:42:34'),
        
        (168,61,'8.4.4.2.1.','Undersøgelse af eksekutive funktioner hos børn og unge særlig med vægt på BRIEF og D-KEFS',12,'','2017-10-16 17:42:58','2017-10-16 17:42:58'),
        
        (169,62,'8.4.4.2.2.1','Udredning',50,'','2017-10-16 17:43:28','2017-10-16 17:43:28'),
        
        (170,62,'8.4.4.2.2.2.','Intervention',50,'','2017-10-16 17:43:48','2017-10-16 17:43:48'),
        
        (171,62,'3.99.,','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 17:44:09','2017-10-16 17:44:09'),
        
        (172,62,'3.99.,','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 17:44:34','2017-10-16 17:44:34'),
        
        (173,63,'7.4.4.2.1.','Socio-emotionelle kompetencer hos børn - teori og praksis',3,'','2017-10-16 17:50:48','2017-10-16 17:50:48'),
        
        (174,63,'7.4.4.2.1.','Parenting in relation to children\'s social-emotional development and resilience in early childhood',3,'','2017-10-16 17:51:10','2017-10-16 17:51:10'),
        
        (175,64,' 7.4.4.2.2','Undersøgelse af eksekutive funktioner hos børn og unge særlig med vægt på BRIEF og D-KEFS',3,'','2017-10-16 17:51:38','2017-10-17 10:34:42'),
        
        (176,65,'7.4.4.2.3.','Socio-emotionelle kompetencer hos børn - teori og praksis',3,'','2017-10-16 17:52:12','2017-10-16 17:52:12'),
        
        (177,65,'7.4.4.2.3.','Parenting in relation to children\'s social-emotional development and resilience in early childhood',3,'','2017-10-16 17:52:35','2017-10-16 17:52:35'),
        
        (178,65,'7.4.4.2.3.','Undersøgelse af eksekutive funktioner hos børn og unge særlig med vægt på BRIEF og D-KEFS',6,'','2017-10-16 17:52:51','2017-10-16 17:52:51'),
        
        (179,66,'7.4.4.2.4','Socio-emotionelle kompetencer hos børn - teori og praksis',3,'','2017-10-16 17:53:12','2017-10-17 10:34:30'),
        
        (180,67,'11.4.4.2.1','MDI og Hamilton - diagnosticering og måling af sværhedsgrad af depression',8,'','2017-10-16 17:55:32','2017-10-17 10:33:06'),
        
        (181,68,'11.4.4.2.2.','Introduktion til Intensiv Dynamisk Korttidsterapi',12,'','2017-10-16 17:55:57','2017-10-16 17:55:57'),
        
        (182,72,'3.99','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-16 17:56:30','2017-10-17 10:32:47'),
        
        (183,72,'3.99','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-16 17:56:50','2017-10-17 10:32:53'),
        
        (190,60,'18.4.4.2.6.1','Organisationsudvikling',0,'','2017-10-17 14:02:07','2017-10-17 14:02:07'),
        
        (191,60,'18.4.4.2.6.2.','Udvikling af grupper og team',0,'','2017-10-17 14:02:22','2017-10-17 14:02:22'),
        
        (192,60,'18.4.4.2.6.3.','Ledelsesudvikling og ledervejledning',0,'','2017-10-17 14:02:34','2017-10-17 14:02:34'),
        
        (193,60,'18.4.4.2.6.4.','Marginalisering/arbejdsfastholdelse',0,'','2017-10-17 14:02:49','2017-10-17 14:02:49'),
        
        (194,60,'18.4.4.2.6.5.','Arbejdspsykologi - Det psykosociale arbejdsmiljø',0,'','2017-10-17 14:03:06','2017-10-17 14:03:06'),
        
        (195,60,'18.4.4.2.6.6.','Testpsykologi',0,'','2017-10-17 14:03:22','2017-10-17 14:03:22'),
        
        (196,60,'18.4.4.2.6.7.','Andet/Øvrige',0,'','2017-10-17 14:03:32','2017-10-17 14:03:32'),
        
        (197,60,'17.4.4.2.6.7','Stress - en psykologisk forståelse',12,'','2017-10-17 14:03:44','2017-10-17 14:04:59'),
        
        (198,60,'3.99','MDI og Hamilton - diagnosticering og måling af sværhedsgrad af depression',6,'','2017-10-17 14:03:59','2017-10-17 14:04:50'),
        
        (199,60,'3.99','Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',12,'','2017-10-17 14:04:12','2017-10-17 14:04:41'),
        
        (200,60,'3.99','Opfølgningsdag - Psykologisk behandling af problematisk vrede hos voksne - i kognitivt adfærdsterapeutisk perspektiv',6,'','2017-10-17 14:04:30','2017-10-17 14:04:30');
        
        ");
    }
}
