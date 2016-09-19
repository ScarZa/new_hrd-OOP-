        <section class="content-header">
              <?php if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><img src='images/adduser.ico' width='40'><font color='blue'>  แก้ไขข้อมูลบุคลากร </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_person.php"><i class="fa fa-edit"></i> ข้อมูลพื้นฐาน</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขข้อมูลบุคลากร</li>
              <?php }}else{?>
            <h1><img src='images/adduser.ico' width='40'><font color='blue'>  เพิ่มข้อมูลบุคลากร </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มข้อมูลบุคลากร</li>
              <?php }?>
            </ol>
        </section>
    <section class="content">
<?php
 
                                $conn_DB2= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
                                $conn_DB2->conn_PDO();
if(isset($method)=='edit'){
        
                                //$conn_DB1= new EnDeCode();
                                //$read="connection/conn_DB.txt";
                                //$conn_DB1->para_read($read);
                                //$conn_DB1->conn_PDO();
        $eid=filter_input(INPUT_GET,'id');
        $edit_id=$conn_DB2->sslDec($eid);
        $sql="select * from emppersonal e1 left outer join educate e2 on e1.empno=e2.empno
            where e1.empno='$edit_id'";
        $conn_DB2->imp_sql($sql);
                                $edit_person=$conn_DB2->select('');
                                $conn_DB2->close_PDO();
}
?>
<form class="" role="form" action='process/prcperson.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
                <div class="box box-success box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> ข้อมูลทั่วไป</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-lg-3 col-xs-12">
                <label>รหัสพนักงาน &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['pid'];}?>' type="text" class="form-control" name="empid" id="empid" placeholder="รหัสพนักงาน" onkeydown="return nextbox(event, 'cidid')" required>
             	</div>
                    <div class="col-lg-3 col-xs-12"> 
                    <label>หมายเลขบัตรประชาชน &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['idcard'];}?>' type="text" class="form-control" name="cidid" id="cidid" placeholder="หมายเลขบัตรประชาชน" maxlength="13" onkeydown="return nextbox(event, 'pname')" onKeyUp="javascript:inputDigits(this);" required>
                    </div></div>
                    <div class="row">
                    <div class="col-lg-2 col-xs-6">
         			<label>คำนำหน้า &nbsp;</label>
 				<select name="pname" id="pname" required  class="form-control select2" data-placeholder="คำนำหน้า" style="width: 100%;" onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT *  FROM pcode order by pname";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select();
                                //$conn_DB2->close_mysqli();
				 echo "<option value=''>--คำนำหน้า--</option>";
				 for($i=0;$i<count($result);$i++){
                                if($result[$i]['pcode']==$edit_person[0]['pcode']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['pcode']."' $selected>".$result[$i]['pname']." </option>";
				 } ?> 
			 </select>
			 </div>
                    <div class="col-lg-3 col-xs-12"> 
                <label>ชื่อ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['firstname'];}?>' type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" onkeydown="return nextbox(event, 'lname')" onKeyUp="javascript:inputString(this);" required>
             	</div>
                    <div class="col-lg-3 col-xs-12"> 
                <label>นามสกุล &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['lastname'];}?>' type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล" onkeydown="return nextbox(event, 'sex')" onKeyUp="javascript:inputString(this);" required>
                    </div>
                <div class="col-lg-2 col-xs-6">
         			<label>เพศ &nbsp;</label>
 				<select name="sex" id="sex" required  class="form-control"  onkeydown="return nextbox(event, 'bday');">
                                    <?php if(!empty($edit_person[0]['sex'])){
                                          if($edit_person[0]['sex']==1){?>
                                <option value=''> เพศ </option>
                                <option value='1' selected=""> ชาย </option>
                                <option value='2'> หญิง </option>
                                          <?php }elseif($edit_person[0]['sex']==2){?>
                                <option value=''> เพศ </option>
                                <option value='1'> ชาย </option>
                                <option value='2' selected=""> หญิง </option>
                                    <?php }}  else {?>
                                <option value=''> เพศ </option>
                                <option value='1'> ชาย </option>
                                <option value='2'> หญิง </option>        
                                <?php }?>
				 </select>
			 </div>
                <div class="col-lg-2 col-xs-6"> 
                <label>วันเดือนปีเกิด &nbsp;</label>
                <?php
 		if(isset($_GET['method'])){
 			$take_date=$edit_person['birthdate'];
 			edit_date($take_date);
                        }
 		?>
                <p><input name="bday" type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" value="<?php if(isset($_GET['method'])){echo $take_date;}?>" required></p>
                </div>
                    </div>
                    <div class="row">
                <div class="col-lg-3 col-xs-12"> 
                <label>ที่อยุ่บ้านเลขที่ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['address'];}?>' type="text" class="form-control" name="address" id="address" placeholder="บ้านเลขที่" onkeydown="return nextbox(event, 'hname')" required>
             	</div>
                <div class="col-lg-3 col-xs-12"> 
                <label>ชื่อหมู่บ้าน &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['baan'];}?>' type="text" class="form-control" name="hname" id="hname" placeholder="ชื่อหมู่บ้าน" onkeydown="return nextbox(event, 'postcode')">
                </div></div>
                <div class="row">
                <?php include_once 'js/address.php';?>
                <div class="col-lg-3 col-xs-12"> 
                <label>รหัสไปรษณีย์ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['zipcode'];}?>' type="text" class="form-control" name="postcode" id="postcode" placeholder="รหัสไปรษณีย์" maxlength="5" onkeydown="return nextbox(event, 'status')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    </div>
                    <div class="row">
                <div class="col-lg-3 ol-xs-12">
         			<label>สถานะภาพ &nbsp;</label>
 				<select name="status" id="status" required  class="form-control select2" data-placeholder="สถานะภาพ"  style="width: 100%;" onkeydown="return nextbox(event, 'htell');"> 
				<?php	$sql = "SELECT *  FROM empstatus order by status";
                                //$conn_DB2->conn_mysqli();
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select();
                                //$conn_DB2->close_mysqli();
				 echo "<option value=''>--สถานะภาพ--</option>";
				 for($i=0;$i<count($result);$i++){
                    if($result[$i]['status']==$edit_person[0]['status']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['status']."' $selected>".$result[$i]['statusname']." </option>";
				 } ?>
			 </select>
			 </div>
                <div class="col-lg-3 ol-xs-12"> 
                <label>เบอร์โทรศัพท์บ้าน &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['telephone'];}?>' type="text" class="form-control" name="htell" id="htell" placeholder="เบอร์โทรศัพท์บ้าน" maxlength="9" onkeydown="return nextbox(event, 'mtell')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                <div class="col-lg-3 ol-xs-12"> 
                <label>เบอร์โทรศัพท์มือถือ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['mobile'];}?>' type="text" class="form-control" name="mtell" id="mtell" placeholder="เบอร์โทรศัพท์มือถือ" maxlength="10" onkeydown="return nextbox(event, 'email')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                <div class="col-lg-3 ol-xs-12"> 
                <label>e-mail &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['email'];}?>' type="email" class="form-control" name="email" id="email" placeholder="email" onkeydown="return nextbox(event, 'order')">
             	</div>
                    </div>
                    <div class="row">
                <div class="col-lg-3 ol-xs-12">
                <label>รูปถ่าย &nbsp;</label>
                <input type="file" name="image" id="exampleInputFile" class="form-control"/>
                    </div>
                    </div>
                </div>
                </div>


          </div>
</div>
    <div class="row">
          <div class="col-lg-12">
              <div class="box box-primary box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/work.ico' width='25'> ข้อมูลการปฏิบัติงาน</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-lg-3 ol-xs-12"> 
                <label>คำสั่งเลขที่ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['empcode'];}?>' type="text" class="form-control" name="order" id="order" placeholder="เลขที่คำสั่ง" onkeydown="return nextbox(event, 'position')">
             	</div>
                  <div class="col-lg-3 ol-xs-12">
                      <div class="form-group">
         			<label>ตำแหน่ง &nbsp;</label>
 				<select name="position" id="position" required  class="form-control select2"  data-placeholder="ตำแหน่ง"  style="width: 100%;" onkeydown="return nextbox(event, 'dep');"> 
				<?php 
                                $sql = "SELECT *  FROM posid order by posId";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--ตำแหน่ง--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['posId']==$edit_person[0]['posid']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['posId']."' $selected>".$result[$i]['posname']." </option>";
				 } ?>
			 </select>
                      </div></div>
                    <div class="col-lg-3 ol-xs-12">
                        <div class="form-group">
         			<label>ฝ่ายงาน &nbsp;</label>
 				<select name="dep" id="dep" required  class="form-control select2"  data-placeholder="ฝ่ายงาน"  style="width: 100%;" onkeydown="return nextbox(event, 'line');"> 
				<?php 
                                $sql = "SELECT *  FROM department order by depId";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--ฝ่ายงาน--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['depId']==$edit_person[0]['depid']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['depId']."' $selected>".$result[$i]['depName']." </option>";
				 } ?>
                                </select></div></div>
                    <div class="col-lg-3 ol-xs-12">
                        <div class="form-group">
                            <div class="form-group">
         			<label>สายงาน &nbsp;</label>
 				<select name="line" id="line" required  class="form-control select2"  data-placeholder="สายงาน"  style="width: 100%;"  onkeydown="return nextbox(event, 'pertype');"> 
				<?php  
                                $sql = "SELECT *  FROM empstuc order by Emstuc";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--สายงาน--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['Emstuc']==$edit_person[0]['empstuc']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['Emstuc']."' $selected>".$result[$i]['StucName']." </option>";
				 } ?>
			 </select>
                            </div></div>
                    </div></div>
                    <div class="row">
                    <div class="col-lg-3 ol-xs-12">
                        <div class="form-group">
         			<label>ประเภทพนักงาน &nbsp;</label>
 				<select name="pertype" id="pertype" required  class="form-control select2" data-placeholder="ประเภทพนักงาน"  style="width: 100%;" onkeydown="return nextbox(event, 'educat');"> 
				<?php 
                                $sql = "SELECT *  FROM emptype order by EmpType";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--ประเภทพนักงาน--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['EmpType']==$edit_person[0]['emptype']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['EmpType']."' $selected>".$result[$i]['TypeName']." </option>";
				 } ?>
			 </select>
                        </div></div>
                    <div class="col-lg-3 ol-xs-12">
                        <div class="form-group">
         			<label>วุฒิการศึกษาที่บรรจุ &nbsp;</label>
 				<select name="educat" id="educat" required  class="form-control select2" data-placeholder="วุฒิการศึกษาที่บรรจุ"  style="width: 100%;" onkeydown="return nextbox(event, 'swday');"> 
				<?php
                                $sql = "SELECT *  FROM education order by education";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--วุฒิการศึกษาที่บรรจุ--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['education']==$edit_person[0]['education']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['education']."' $selected>".$result[$i]['eduname']." </option>";
				 } ?>
			 </select>
                        </div></div>
                    <div class="col-lg-3 ol-xs-12"> 
                <label>วันที่เริ่มปฏิบัติงาน &nbsp;</label>
                <?php
 		if(isset($_GET['method'])){
 			$dateBegin=$edit_person['dateBegin'];
 			edit_date($dateBegin);
                        }
 		?>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $dateBegin;}?>' type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" name="swday" id="swday" onkeydown="return nextbox(event, 'teducat')">
                    </div></div>
                </div>
              </div>
          </div>
</div>
    <div class="row">
          <div class="col-lg-12">
              <div class="box box-info box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/Student.ico' width='25'> ข้อมูลการศึกษา</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-lg-3 ol-xs-12">
                        <div class="form-group">
         			<label>วุฒิการศึกษา &nbsp;</label>
 				<select name="teducat" id="teducat" class="form-control select2" data-placeholder="วุฒิการศึกษา"  style="width: 100%;"  onkeydown="return nextbox(event, 'major');"> 
				<?php 
                                $sql = "SELECT *  FROM education order by education";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--วุฒิการศึกษา--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['education']==$edit_person[0]['educate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['education']."' $selected>".$result[$i]['eduname']." </option>";
				 } ?>
			 </select>
                        </div></div>
                    <div class="col-lg-3 ol-xs-12"> 
                <label>สาขา/วิชาเอก &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['major'];}?>' type="text" class="form-control" name="major" id="major" placeholder="สาขา/วิชาเอก" onkeydown="return nextbox(event, 'inst')">
             	</div>
                    <div class="col-lg-3 ol-xs-12"> 
                <label>สถาบันที่จบ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['institute'];}?>' type="text" class="form-control" name="inst" id="inst" placeholder="ชื่อสถาบัน" onkeydown="return nextbox(event, 'Graduation')">
             	</div>
                    <div class="col-lg-3 ol-xs-12"> 
                <label>วันที่จบการศึกษา &nbsp;</label>
                <?php
 		if(isset($_GET['method'])){
 			$enddate=$edit_person['enddate'];
 			edit_date($enddate);
                        }
 		?>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $enddate;}?>' type="text" id="datepicker3"  placeholder='รูปแบบ 22/07/2557' class="form-control" name="Graduation" id="Graduation" onkeydown="return nextbox(event, 'statusw')">
                    
                    </div></div>
                </div>


          </div>
</div></div>
    <div class="row">
          <div class="col-lg-12">
                           <div class="box box-warning box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/Other.ico' width='25'> ข้อมูลอื่นๆ</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-lg-3 ol-xs-12">
                        <div class="form-group">
         			<label>สถานะการทำงาน &nbsp;</label>
 				<select name="statusw" id="statusw" required  class="form-control select2" data-placeholder="สถานะการทำงาน"  style="width: 100%;" onkeydown="return nextbox(event, 'reason');"> 
				<?php 
                                $sql = "SELECT *  FROM emstatus order by statusid";
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
				 echo "<option value=''>--สถานะการทำงาน--</option>";
				 for($i=0;$i<count($result);$i++){
          if($result[$i]['statusid']==$edit_person[0]['status']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result[$i]['statusid']."'$selected>".$result[$i]['statusname']." </option>";
				 } ?>
			 </select>
                        </div></div></div>
                    <div class="row">
                    <div class="col-lg-6 ol-xs-6"> 
                <label>เหตุผลการลาออก/สถานที่ย้ายไป/มาช่วยราชการ/ไปช่วยราชการ &nbsp;</label>
                <TEXTAREA value='' NAME="reason" id="reason"  class="form-control" onkeydown="return nextbox(event, 'movedate')"><?php if(isset($_REQUEST['method'])){ echo $edit_person['empnote'];}?></TEXTAREA>
                    </div></div>
                    <div class="row">
                    <div class="col-lg-3 ol-xs-12"> 
                <label>วันที่ ย้าย/ลาออก/ไปช่วยราชการ &nbsp;</label>
                <input value='<?php if(isset($_REQUEST['method'])){ echo $edit_person['dateEnd'];}?>' type="text" class="form-control" name="movedate" id="datepicker4" placeholder="รูปแบบ 2015-01-31" onkeydown="return nextbox(event, 'Submit')">
                    </div></div>
                </div>
                </div>


          </div>
          </div>
    <?php if(isset($_REQUEST['method'])){
    if($_REQUEST['method']=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person['empno'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
    <?php }}else{?> 
   <input type="hidden" name="method" id="method" value="add_person">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }?>
</form>
</section>
 
         