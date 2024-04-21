create table courses(
    course_id INT PRIMARY KEY,
    course_code varchar(20),
    course_name varchar(100),
    credit INT,
    isoptional varchar(20),
    department varchar(20),
    grade varchar(20),
    professor varchar(100),
    spot INT
);

insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1311	, "GEID0010",	"班級活動",	0	, "必修",	"資訊系",	"二乙",	"洪振偉",	61);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1312	, "IECS2003",	"系統程式",	3	, "必修",	"資訊系",	"二乙",	"劉宗杰",	70);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1313	, "IECS3022",	"資料庫系統",	3	, "必修",	"資訊系",	"二乙",	"許懷中",	67);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1314	, "IECS2025",	"機率與統計",	3	, "必修",	"資訊系",	"二乙",	"游景盛",	79);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1323	, "IECS2041",	"互連網路",	3	, "選修",	"資訊系",	"二合",	"劉宗杰",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1324	, "IECS2072",	"Web程式設計",	3	, "選修",	"資訊系",	"二合",	"劉明機",	74);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1326	, "IECS2011",	"系統分析與設計",	3	, "選修",	"資訊系",	"二合",	"洪振偉",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1328	, "IECS2027",	"多媒體系統",	3	, "選修",	"資訊系",	"二合",	"葉春秀",	72);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1329	, "IECS2026",	"電子商務安全",	3	, "選修",	"資訊系",	"二合",	"魏國瑞",	67);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1330	, "IECS2026",	"電子商務安全",	3	, "選修",	"資訊系",	"二合",	"周澤捷",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1331	, "IECS2033",	"數位信號處理導論",	3	, "選修",	"資訊系",	"二合",	"陳啟鏘",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1332	, "IECS2053",	"數位系統設計",	3	, "選修",	"資訊系",	"二合",	"陳德生",	55);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1333	, "IECS2014",	"數位系統設計實驗",	1	, "選修",	"資訊系",	"二合",	"陳德生",	55);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1334	, "IECS2006",	"UNIX應用與實務",	2	, "選修",	"資訊系",	"二合",	"林佩蓉",	64);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1272	, "GEID0010",	"班級活動",	0	, "必修",	"資訊系",	"一甲",	"劉怡芬",	62);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1273	, "ATHL1004",	"體育(二)",	1	, "必修",	"資訊系",	"一甲",	"黃嘉君",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1274	, "GEG2000",	"現代公民與社會實踐",	2	, "必修",	"資訊系",	"一甲",	"陳迪暉",	61);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1275	, "IECS1008",	"程式設計(III)",	2	, "必修",	"資訊系",	"一甲",	"蔡國裕",	73);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1276	, "IECS1009",	"程式設計(IV)",	2	, "必修",	"資訊系",	"一甲",	"蔡國裕",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1277	, "IEE1011",	"普通物理-電、磁、光實驗",	1	, "必修",	"資訊系",	"一甲",	"蔡雅芝",	65);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1278	, "MATH1006P",	"微積分(二)實習",	0	, "必修",	"資訊系",	"一甲",	"張志偉",	65);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1279	, "MATH1006",	"微積分(二)",	3	, "必修",	"資訊系",	"一甲",	"王志雄",	65);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1280	, "IEE1005",	"線性代數",	3	, "必修",	"資訊系",	"一甲",	"林佩君",	74);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1281	, "IEE1006",	"邏輯設計",	3	, "必修",	"資訊系",	"一甲",	"陳德生",	65);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1282	, "IEE1007",	"邏輯設計實習",	1	, "必修",	"資訊系",	"一甲",	"陳德生",	64);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1307	, "GEID0010",	"班級活動",	0	, "必修",	"資訊系",	"二甲",	"林佩君",	64);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1308	, "IECS2003",	"系統程式",	3	, "必修",	"資訊系",	"二甲",	"周兆龍",	75);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1309	, "IECS3022",	"資料庫系統",	3	, "必修",	"資訊系",	"二甲",	"林明言",	74);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(1310	, "IECS2025",	"機率與統計",	3	, "必修",	"資訊系",	"二甲",	"劉怡芬",	79);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2197	, "MGT203",	"企業倫理與社會責任",	3	, "必修",	"企管系", 	"三甲",	"張秀樺",	78);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2198	, "MGT492",	"企業管理專題研究(二)",	3	, "必修",	"企管系", 	"三甲",	"蔡汶君,陳建文,黃誠甫,王妙如,張秀樺,仇介民,王智弘,黃禮林,楊曉琳,吳如娟,鄭孟育,張寶蓉",	70);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2199	, "MGT465",	"策略管理",	3	, "必修",	"企管系", 	"三甲",	"張寶蓉",	80);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2200	, "MGT330",	"管理資訊系統",	3	, "必修",	"企管系", 	"三甲",	"吳如娟",	82);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2205	, "MGT376",	"企業資源規劃實務(二)",	3	, "選修",	"企管系", 	"三甲",	"莊玉成",	43);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2206	, "MGT382",	"企業智慧財產權管理",	3	, "選修",	"企管系", 	"三甲",	"顏上詠",	70);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2207	, "MGT323",	"行銷企劃實務",	3	, "選修",	"企管系", 	"三甲",	"張秀樺",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2208	, "MGT350",	"投資組合管理",	3	, "選修",	"企管系", 	"三甲",	"鄭孟育",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2209	, "FINA350",	"投資學",	3	, "選修",	"企管系", 	"三甲",	"楊曉琳",	60);
insert into courses(course_id, course_code, course_name, credit,isoptional, department, grade, professor, spot) values	(2210	, "MGT303",	"產業與競爭分析",	3	, "選修",	"企管系", 	"三甲",	"賴泳龍",	60);






select * from courses;