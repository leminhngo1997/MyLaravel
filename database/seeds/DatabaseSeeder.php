<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(User_RoleSeeder::class);
        $this->call(KhoaSeeder::class);
        $this->call(DoituongSeeder::class);
        $this->call(CosoSeeder::class);
        $this->call(Sv_CosoSeeder::class);
        $this->call(LoaibangdiemSeeder::class);   
        $this->call(BangdiemSeeder::class);  
        $this->call(Bangdiem_DoituongSeeder::class);
        $this->call(TieuchiSeeder::class);   
        $this->call(PhongtraoSeeder::class);  
        $this->call(Tieuchi_PhongtraoSeeder::class);  
        $this->call(Sinhvien_DoituongSeeder::class);  
        // $this->call(LuutruSeeder::class);  
        $this->call(HoatdongSeeder::class);  
        $this->call(Phongtrao_HoatdongSeeder::class);  
    }
}

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Lê Hữu Phúc','email' => '15520639@gm.uit.edu.vn','password' => bcrypt('123456')],
            ['name' => 'Nguyễn Trường Thịnh','email' => '15520844@gm.uit.edu.vn','password' => bcrypt('123456')],
            ['name' => 'Ngô Lê Minh','email' => '15520214@gm.uit.edu.vn','password' => bcrypt('123456')],
            ['name' => 'Lương Nguyễn Gia Lượng','email' => '15520123@gm.uit.edu.vn','password' => bcrypt('123456')],
            ['name' => 'Nguyễn Viết Thinh','email' => '15520456@gm.uit.edu.vn','password' => bcrypt('123456')],
            ['name' => 'cvht','email' => 'cvht@uit.edu.vn','password' => bcrypt('123456')],
            ['name' => 'ctsv','email' => 'ctsv@uit.edu.vn','password' => bcrypt('123456')]
        ]);
        
    }
}

class RolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'sinh viên'],
            ['name' => 'lớp trưởng'],
            ['name' => 'cvht'],
            ['name' => 'ctsv'],
        ]);
        
    }
}

class User_RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            ['sv_id' => 1,'role_id' => 1],
            ['sv_id' => 2,'role_id' => 2],
            ['sv_id' => 3,'role_id' => 1],
            ['sv_id' => 4,'role_id' => 1],
            ['sv_id' => 5,'role_id' => 1],
            ['sv_id' => 6,'role_id' => 3],
            ['sv_id' => 7,'role_id' => 4]
        ]);
        
    }
}

class KhoaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('khoa')->insert([
            ['name' => 'Công Nghệ Phần Mềm'],
            ['name' => 'Hệ Thống Thông Tin'],
            ['name' => 'Khoa Học Máy Tính '],
            ['name' => 'Kĩ Thuật Máy Tính'],
            ['name' => 'Khoa học và Kỹ thuật Thông tin'],
            ['name' => 'Mạng Máy Tính & Truyền Thông'],
            //id = 7
            ['name' => 'Toàn trường'],

        ]);
        
    }
}

class CosoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coso')->insert([
            ['name' => 'HTCL2015','doituong_id'=> 6,'khoa_id' =>2,'siso'=>43],
            ['name' => 'HTCL2016','doituong_id'=> 7,'khoa_id'=>2,'siso'=>44],
            ['name' => 'HTCL2017','doituong_id'=> 8,'khoa_id'=>2,'siso'=>50],
            ['name' => 'HTCL2018','doituong_id'=> 9,'khoa_id'=>2,'siso'=>39],
            ['name' => 'PMCL2016','doituong_id'=> 7,'khoa_id'=>4,'siso'=>51],
            ['name' => 'KHMT2015','doituong_id'=> 6,'khoa_id'=>5,'siso'=>38],
            ['name' => 'PMCL2015','doituong_id'=> 6,'khoa_id'=>4,'siso'=>45],
            ['name' => 'HTTT2018','doituong_id'=> 9,'khoa_id'=>2,'siso'=>42],
            ['name' => 'MMT&TT2015','doituong_id'=> 6,'khoa_id'=>6,'siso'=>41],
            ['name' => 'KHMT2017','doituong_id'=> 8,'khoa_id'=>5,'siso'=>46],
            ['name' => 'PMCL2015','doituong_id'=> 6,'khoa_id' =>1,'siso'=>53],
            ['name' => 'TMĐT2015','doituong_id'=> 6,'khoa_id' =>2,'siso'=>33],
        ]);
        
    }
}

class Sv_CosoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sv_coso')->insert([
            ['sv_id' => 1,'coso_id' => 1],
            ['sv_id' => 2,'coso_id' => 1],
            ['sv_id' => 3,'coso_id' => 1],
            ['sv_id' => 4,'coso_id' => 7],
            ['sv_id' => 5,'coso_id' => 6],
        ]);       
    }
}

class LoaibangdiemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loaibangdiem')->insert([
            ['name' => 'Bảng điểm sinh viên']
        ]);       
    }
}

class DoituongSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doituong')->insert([
            ['name' => 'K2010'],
            ['name' => 'K2011'],
            ['name' => 'K2012'],
            ['name' => 'K2013'],
            ['name' => 'K2014'],
            ['name' => 'K2015'],
            ['name' => 'K2016'],
            ['name' => 'K2017'],
            ['name' => 'K2018'],
            ['name' => 'K2019'],
        ]);       
    }
}

class BangdiemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bangdiem')->insert([
            ['name' => 'HK1 2014-2015','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2014-08-14','ngayketthuc'=>'2015-01-18'],
            ['name' => 'HK2 2014-2015','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2015-01-19','ngayketthuc'=>'2015-01-19'],
            ['name' => 'HK1 2015-2016','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2015-08-24','ngayketthuc'=>'2016-02-25'],
            ['name' => 'HK2 2015-2016','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2016-01-26','ngayketthuc'=>'2016-08-28'],
            ['name' => 'HK1 2016-2017','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2016-09-05','ngayketthuc'=>'2017-09-30'],
            ['name' => 'HK2 2016-2017','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2017-02-06','ngayketthuc'=>'2017-09-30'],
            ['name' => 'HK1 2017-2018','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2017-09-05','ngayketthuc'=>'2018-03-27'],
            ['name' => 'HK2 2017-2018','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2018-01-22','ngayketthuc'=>'2018-09-30'],
            ['name' => 'HK1 2018-2019','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2018-08-31','ngayketthuc'=>'2019-03-12'],
            ['name' => 'HK2 2018-2019','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2019-02-18','ngayketthuc'=>'2019-09-30'],
            ['name' => 'HK1 2019-2020','loaibangdiem_id' => 1,'maxbangdiem'=> 100,'ngaybatdau'=>'2019-09-03','ngayketthuc'=>'2020-02-29']  
        ]);
        
    }
}

class Bangdiem_DoituongSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bangdiem_doituong')->insert([
            //Khóa 2014
            ['bangdiem_id' => 1,'doituong_id' => 5],
            ['bangdiem_id' => 2,'doituong_id' => 5],
            ['bangdiem_id' => 3,'doituong_id' => 5],
            ['bangdiem_id' => 4,'doituong_id' => 5],
            ['bangdiem_id' => 5,'doituong_id' => 5],
            ['bangdiem_id' => 6,'doituong_id' => 5],
            ['bangdiem_id' => 7,'doituong_id' => 5],
            ['bangdiem_id' => 8,'doituong_id' => 5],
            ['bangdiem_id' => 9,'doituong_id' => 5],
            //Khóa 2015
            ['bangdiem_id' => 3,'doituong_id' => 6],
            ['bangdiem_id' => 4,'doituong_id' => 6],
            ['bangdiem_id' => 5,'doituong_id' => 6],
            ['bangdiem_id' => 6,'doituong_id' => 6],
            ['bangdiem_id' => 7,'doituong_id' => 6],
            ['bangdiem_id' => 8,'doituong_id' => 6],
            ['bangdiem_id' => 9,'doituong_id' => 6],
            ['bangdiem_id' => 10,'doituong_id' => 6],
            ['bangdiem_id' => 11,'doituong_id' => 6],
            //Khóa 2016
            ['bangdiem_id' => 5,'doituong_id' => 7],
            ['bangdiem_id' => 6,'doituong_id' => 7],
            ['bangdiem_id' => 7,'doituong_id' => 7],
            ['bangdiem_id' => 8,'doituong_id' => 7],
            ['bangdiem_id' => 9,'doituong_id' => 7],
            ['bangdiem_id' => 10,'doituong_id' => 7],
            ['bangdiem_id' => 11,'doituong_id' => 7],
        ]);
        
    }
}

class TieuchiSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tieuchi')->insert([
            //HK1 2015-2016
            ['name' => 'Ý thức học tập và nghiên cứu khoa học','bangdiem_id' => 3,'maxtieuchi'=> 30],
            ['name' => 'Ý thức chấp hành nội quy, quy chế của Trường và ĐHQG-HCM','bangdiem_id' => 3,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ, thể thao, phòng chống các tệ nạn xã hội','bangdiem_id' => 3,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 3,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham công tác cán bộ lớp, các đoàn thể, tổ chức trong Trường. Sinh viên đạt thành tích đặc biệt trong học tập','bangdiem_id' => 3,'maxtieuchi'=> 10],
            //HK2 2015-2016
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 4,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 4,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 4,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 4,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 4,'maxtieuchi'=> 10],
            //HK1 2016-2017
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 5,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 5,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 5,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 5,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 5,'maxtieuchi'=> 10],
            //HK2 2016-2017
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 6,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 6,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 6,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 6,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 6,'maxtieuchi'=> 10],
            //HK1 2017-2018
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 7,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 7,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 7,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 7,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 7,'maxtieuchi'=> 10],
            //HK2 2017-2018
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 8,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 8,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 8,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 8,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 8,'maxtieuchi'=> 10],
            //HK1 2018-2019
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 9,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 9,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 9,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 9,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 9,'maxtieuchi'=> 10],
            //HK2 2018-2019
            ['name' => 'Ý thức tham gia học tập','bangdiem_id' => 10,'maxtieuchi'=> 20],
            ['name' => 'Ý thức chấp hành nội quy, quy chế','bangdiem_id' => 10,'maxtieuchi'=> 25],
            ['name' => 'Ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ','bangdiem_id' => 10,'maxtieuchi'=> 20],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 10,'maxtieuchi'=> 25],
            ['name' => 'Ý thức và kết quả tham gia công tác cán bộ lớp, đoàn thể','bangdiem_id' => 10,'maxtieuchi'=> 10],
            //HK1 2019-2020
            ['name' => 'Ý thức và thái độ tham gia học tập và nghiên cứu khoa học','bangdiem_id' => 11,'maxtieuchi'=> 30],
            ['name' => 'Ý thức chấp hành nội quy, quy chế, quy định trong Nhà trường','bangdiem_id' => 11,'maxtieuchi'=> 20],
            ['name' => 'Ý thức tham gia các hoạt động CT, XH, VH, VN, TDTT, phòng chống tội phạm và các TNXH','bangdiem_id' => 11,'maxtieuchi'=> 25],
            ['name' => 'Ý thức công dân trong quan hệ cộng đồng','bangdiem_id' => 11,'maxtieuchi'=> 25],
            ['name' => 'Các nội dung cộng thêm','bangdiem_id' => 11,'maxtieuchi'=> 10],
        ]);
        
    }
}

class PhongtraoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phongtrao')->insert([
            //---HK1 2019-2020---Tiêu chí 1
            ['name' => 'Quy chế đào tạo, kiểm tra, thi và công nhận tốt nghiệp đại học, cao đẳng chính quy trong năm','maxphongtrao'=> 15],
            ['name' => 'Tham gia cuộc thi học thuật','maxphongtrao'=> 30],
            ['name' => 'Kết quả học tập và nghiên cứu khoa học','maxphongtrao'=> 12],
            ['name' => 'Tham gia các CLB học thuật, hoạt động học thuật, hoạt động nghiên cứu khoa học','maxphongtrao'=> 30],
            ['name' => 'Hoàn thành tập huấn thư viện trung tâm','maxphongtrao'=> 5],
            ['name' => 'BTC, CTV, SV tham gia hỗ trợ trợ các hoạt động học thuật','maxphongtrao'=> 30],
            ['name' => 'Tin thần vượt khó, phấn đấu vươn lên trong học tập','maxphongtrao'=> 5],
            //---HK1 2019-2020---Tiêu chí 2
            ['name' => 'Tham gia các buổi sinh hoạt lớp','maxphongtrao'=> 15],
            //---HK1 2019-2020---Tiêu chí 3
            ['name' => 'Tham gia các hoạt động do lớp (chi đoàn, chi hội, câu lạc bộ) tổ chức','maxphongtrao'=> 20],
            ['name' => 'Tham gia các hoạt động do Khoa, Trường tổ chức','maxphongtrao'=> 20],
            ['name' => 'Tham gia các lớp nâng cao kỹ năng cho sinh viên','maxphongtrao'=> 30],
            //---HK1 2019-2020---Tiêu chí 4
            ['name' => 'Tham gia các hoạt động do lớp (chi đoàn, chi hội, câu lạc bộ) tổ chức','maxphongtrao'=> 20],
            ['name' => 'Tham gia các hoạt động do Khoa, Trường tổ chức','maxphongtrao'=> 20],
            
            // ['name' => '','maxphongtrao'=> ],
          
        ]);
        
    }
}

class Tieuchi_PhongtraoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tieuchi_phongtrao')->insert([
            //---HK1 2019-2020---Tiêu chí 1
            //Phong trào 
            ['tieuchi_id' => 41,'phongtrao_id'=> 1],
            ['tieuchi_id' => 41,'phongtrao_id'=> 2],
            ['tieuchi_id' => 41,'phongtrao_id'=> 3],
            ['tieuchi_id' => 41,'phongtrao_id'=> 4],
            ['tieuchi_id' => 41,'phongtrao_id'=> 5],
            ['tieuchi_id' => 41,'phongtrao_id'=> 6],
            ['tieuchi_id' => 41,'phongtrao_id'=> 7],
            //---HK1 2019-2020---Tiêu chí 2
            ['tieuchi_id' => 42,'phongtrao_id'=> 8],
            //---HK1 2019-2020---Tiêu chí 3
            ['tieuchi_id' => 43,'phongtrao_id'=> 9],
            ['tieuchi_id' => 43,'phongtrao_id'=> 10],
            ['tieuchi_id' => 43,'phongtrao_id'=> 11],
             //---HK1 2019-2020---Tiêu chí 4
            ['tieuchi_id' => 44,'phongtrao_id'=> 12],
            ['tieuchi_id' => 44,'phongtrao_id'=> 13],
         
            // ['tieuchi_id' => ,'phongtrao_id'=> ],
            
          
        ]);
        
    }
}

class Sinhvien_DoituongSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sinhvien_doituong')->insert([
            ['sv_id' => 1,'doituong_id' => 6],
            ['sv_id' => 3,'doituong_id' => 6],
            ['sv_id' => 4,'doituong_id' => 6],
            ['sv_id' => 5,'doituong_id' => 6],        
        ]);
        
    }
}

// class LuutruSeeder extends Seeder
// {
//     /**
//      * Seed the application's database.
//      *
//      * @return void
//      */
//     public function run()
//     {
//         DB::table('luutru')->insert([
//             ['sv_id' => 1,'bangdiem_id' => ,'diem' => ,'xeploai' =>],
//             ['sv_id' => 3,'doituong_id' => 6],
//             ['sv_id' => 4,'doituong_id' => 6],
//             ['sv_id' => 5,'doituong_id' => 6],        
//         ]);
        
//     }
// }

class HoatdongSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hoatdong')->insert([
            //HK1 2019-2020
            //--Tiêu chí 1
            //-- --Phong trào 1
            ['name' => 'Không vi phạm quy chế','diem'=> 15,'doituong' => 'Tất cả','ngaybatdau'=> '2019-09-03','ngayketthuc'=> '2020-02-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            //-- --Phong trào 2
            ['name' => 'Tham gia và giải được bài ở cuộc thi ICPC online các vòng miền Trung ngày 6/10/2019','diem'=> 5,'doituong' => 'Tất cả','ngaybatdau'=> '2019-10-06','ngayketthuc'=> '2019-10-06','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => 'Tham gia và giải được bài ở cuộc thi ICPC online các vòng miền Bắc ngày 13/10/2019','diem'=> 5,'doituong' => 'Tất cả','ngaybatdau'=> '2019-10-13','ngayketthuc'=> '2019-10-13','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => 'Tham gia và giải được bài ở cuộc ICPC online các vòng miền Nam ngày 20/10/2019','diem'=> 5,'doituong' => 'Tất cả','ngaybatdau'=> '2019-10-20','ngayketthuc'=> '2019-10-20','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => 'Tham gia và giải được bài ở cuộc thi ICPC Quốc gia năm 2019 ngày 3/11/2019','diem'=> 5,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-03','ngayketthuc'=> '2019-11-03','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            //-- --Phong trào 4
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - GIẢI TÍCH','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - NHẬP MÔN LẬP TRÌNH','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - NHẬP MÔN ĐIỆN TỬ','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - NHẬP MÔN MẠCH SỐ','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - KIẾN TRÚC MÁY TÍNH','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - NHẬP MÔN MẠNG MÁY TÍNH','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => '[KH&KTTT - BHTCNTT] TRAINING GIỮA KÌ 1 2019-2020 - CƠ SỞ DỮ LIỆU','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '2019-11-29','ngayketthuc'=> '2019-11-29','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
             //-- --Phong trào 5
            ['name' => 'Nhận thẻ thư viện trung tâm','diem'=> 5,'doituong' => 'Tất cả','ngaybatdau'=> '2019-09-01','ngayketthuc'=> '2019-11-22','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => 'Cộng tác viên hỗ trợ cuộc thi ICPC online các vòng miền Bắc ngày 13/10/2019','diem'=> 8,'doituong' => 'Tất cả','ngaybatdau'=> '2019-10-13','ngayketthuc'=> '2019-10-13','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            ['name' => 'CTV hỗ trợ cuộc thi ICPC online các vòng miền Nam ngày 20/10/2019','diem'=> 8,'doituong' => 'Tất cả','ngaybatdau'=> '2019-10-20','ngayketthuc'=> '2019-10-20','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            // ['name' => '','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '','ngayketthuc'=> '','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],
            // ['name' => '','diem'=> 3,'doituong' => 'Tất cả','ngaybatdau'=> '','ngayketthuc'=> '','nguoitao'=> 'ctsv','nguoiduyet'=> 'ctsv','status_clone'=> 1],

        ]);
        
    }
}

class Phongtrao_HoatdongSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phongtrao_hoatdong')->insert([
            //HK1 2019-2020
            //--Tiêu chí 1
            //-- --Phong trào 1
            ['phongtrao_id' => 1,'hoatdong_id' => 1,'status' => 1,'nguoiduyet' => 'ctsv'],
            //-- --Phong trào 2
            ['phongtrao_id' => 2,'hoatdong_id' => 2,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 2,'hoatdong_id' => 3,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 2,'hoatdong_id' => 4,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 2,'hoatdong_id' => 5,'status' => 1,'nguoiduyet' => 'ctsv'],
            //-- --Phong trào 4
            ['phongtrao_id' => 4,'hoatdong_id' => 6,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 4,'hoatdong_id' => 7,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 4,'hoatdong_id' => 8,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 4,'hoatdong_id' => 9,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 4,'hoatdong_id' => 10,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 4,'hoatdong_id' => 11,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 4,'hoatdong_id' => 12,'status' => 1,'nguoiduyet' => 'ctsv'],
            //-- --Phong trào 5
            ['phongtrao_id' => 5,'hoatdong_id' => 13,'status' => 1,'nguoiduyet' => 'ctsv'],
            //-- --Phong trào 6
            ['phongtrao_id' => 6,'hoatdong_id' => 14,'status' => 1,'nguoiduyet' => 'ctsv'],
            ['phongtrao_id' => 6,'hoatdong_id' => 15,'status' => 1,'nguoiduyet' => 'ctsv'],     
        ]);
        
    }
}