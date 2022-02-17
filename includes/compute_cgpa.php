<?php
	function point($grade){
		if($grade=='A') return 5;
		elseif($grade=='B') return 4;
		elseif($grade=='C') return 3;
		elseif($grade=='D') return 2;
		elseif($grade=='E') return 1;
		elseif($grade=='F') return 0;
	}
	function probate($cgp=0.00){	
	    
		
		if($cgp < 0.75){ return "withdrawn";}
		elseif($cgp >= 0.75 && $cgp < 1.00)  {return "probation";}
		elseif($cgp >= 1.00) {return "promoted";}
		
	}
	function pass($cgp){
		$probation = 1.0;
		$pas = 1.5;
		$third = 2.4;
		$second_2 = 3.5;
		$second_1 = 4.5;
		
		$status="";
		if($cgp >= $second_1) { $status="First Class";}
		elseif($cgp >= $second_2) { $status="Second Class (Upper Division)";}
		elseif($cgp >= $third) { $status="Second Class (Lower Division)";}
		elseif($cgp >= $pas) { $status="Third Class";}
		elseif($cgp >= $probation) { $status="Pass";}
		return $status;
	}
	
	function compute_summer_cgpa($id, $a_session){
		$new_status=""; $no_of_years = 0; $level=0;
		$students = Student::find_by_id($id);
		foreach($students as $student){
			$case="";
			$session_id=0;
			$sess=Academic_session::find_session($a_session);
			foreach($sess as $ses){
				$session_id = $ses->id;
			}
			$status111 =  Student_status::find_by_stdnt($student->id, $session_id);
			foreach($status111 as $state1):
				$no_of_years = $state1->no_of_years;
				$case = $state1->case_status;
				$level = $state1->level;
			endforeach;
			$product=0;
			$total_point=0;
			$total_credit=0;
			$cum_credit=0;
			$cum_point=0;
			$cgpa=0.0;
			$gpa=0.0;
			$sm1_id=0;
			$sm2_id=0;
			$sm11_id=0;
			$sm22_id=0;
			$retrieved=1;
			
			$sem1=Semester::find($a_session, "first");
				foreach($sem1 as $sem){
				 $sm11_id=$sem->id;
				}
				$sem2=Semester::find($a_session, "second");
				foreach($sem2 as $em){
				 $sm22_id=$em->id;
				}
				$rpt=0;$no_reg=0;
				$finde = Result_sheet::find_summer($sm11_id, $sm22_id, $id);
				//Result_sheet::find_summer($sm1_, $sm2_, $student->id);
				//$fin1 = Result_sheet::find_active($student->id, $sm11_id); 
				//$fin2 = Result_sheet::find_active($student->id, $sm22_id);
				//if(empty($fin1) || empty($fin2)) $no_reg=1;
				foreach($finde as $fin){
				 
				 $crd=0;
				 $semes="";
				$corz=Course::find_by_id($fin->course_id);
				foreach($corz as $corx){
				 $crd=$corx->credit_unit;
				
				}
				
				if($fin->status==3){
				$product=$crd*point(grade(total($fin->assessment,$fin->exam_score)));
				$total_point = $total_point + $product;
				$total_credit = $total_credit + $crd;
				}
				//elseif($fin->status==0) $retrieved=0;
				
			}
			$gpa = ($total_point/$total_credit);
				$gpa = round($gpa, 2);
				
		}
		
		$current_session = $student->session_of_entry;
					$continue=0;
					$case1="";
					while($continue!=1){
						$sesse=Academic_session::find_session($current_session);
						foreach($sesse as $sese){
							$sesi_id = $sese->id;
						}
						$status = Student_status::find_by_stdnt($student->id, $sesi_id);;
						foreach($status as $statee):
							$case1 = $statee->case_status;
						endforeach;
						if($case1=="FR" || $case1="MC"){
							$sem1=Semester::find($current_session, "first");
							foreach($sem1 as $sem){
							 $sm1_id=$sem->id;
							}
							$sem2=Semester::find($current_session, "second");
							foreach($sem2 as $sem){
							 $sm2_id=$sem->id;
							}
							$rpt=0;
							$regste = Result_sheet::find_by_sem($sm1_id, $sm2_id, $id);
							foreach($regste as $rege){
								
								$crd=0;
								
							       $corz=Course::find_by_id($rege->course_id);
							       foreach($corz as $corx){
								$crd=$corx->credit_unit;
							       }
								
								if($rege->status==1 || $rege->status==2 || $rege->status==3){
								
							       $product=$crd*point(grade(total($rege->assessment,$rege->exam_score)));
							       $cum_point = $cum_point + $product;
							       $cum_credit = $cum_credit + $crd;
							       }
								
							}
						}
						//echo $current_session;
						if($current_session==$a_session) $continue=1;
						else $current_session=next_session($current_session);
					}
					$cgpa = $cum_point/$cum_credit;
					$cgpa = round($cgpa, 2);
					
					$strgp=$gpa.""; 
				$gpa=conca($strgp);
				$CGPA = array();
				$CGPA[0] = $total_point;
				$CGPA[1] = $total_credit;
				$CGPA[2] = $gpa;
				$strcgp=$cgpa."";
				$cgpa=conca($strcgp);
				$CGPA[3] = $cum_point;
				$CGPA[4] = $cum_credit;
				$CGPA[5] = $cgpa;
				
				$CGPA[6] = $retrieved;
				return $CGPA;
					
	}
	
	function compute_cgpa($id, $a_session){
		$new_status=""; $no_of_years = 0; $level=0;
		$students = Student::find_by_id($id);
		foreach($students as $student):
			
			$case="";
			$session_id=0;
			$sess=Academic_session::find_session($a_session);
			foreach($sess as $ses){
				$session_id = $ses->id;
			}
			$status111 =  Student_status::find_by_stdnt($student->id, $session_id);
			foreach($status111 as $state1):
				$no_of_years = $state1->no_of_years;
				$case = $state1->case_status;
				$level = $state1->level;
			endforeach;
			$product=0;
			$total_point=0;
			$total_credit=0;
			$cum_credit=0;
			$cum_point=0;
			$cgpa=0.0;
			$gpa=0.0;
			$sm1_id=0;
			$sm2_id=0;
			$sm11_id=0;
			$sm22_id=0;
			$retrieved=1;
			if($case="FR" || $case="MC"){
				
				$sem1=Semester::find($a_session, "first");
				foreach($sem1 as $sem){
				 $sm11_id=$sem->id;
				}
				$sem2=Semester::find($a_session, "second");
				foreach($sem2 as $em){
				 $sm22_id=$em->id;
				}
				$rpt=0;$no_reg=0;
				$finde = Result_sheet::find_by_sem($sm11_id, $sm22_id, $id);
				$fin1 = Result_sheet::find_active($student->id, $sm11_id); 
				$fin2 = Result_sheet::find_active($student->id, $sm22_id);
				if(empty($fin1) || empty($fin2)) $no_reg=1;
				foreach($finde as $fin){
				 
				 $crd=0;
				 $semes="";
				$corz=Course::find_by_id($fin->course_id);
				foreach($corz as $corx){
				 $crd=$corx->credit_unit;
				
				}
				
				if($fin->status==1 || $fin->status==2){
				$product=$crd*point(grade(total($fin->assessment,$fin->exam_score)));
				$total_point = $total_point + $product;
				$total_credit = $total_credit + $crd;
				}elseif($fin->status==0) $retrieved=0;
				
			}
			$gpa = ($total_point/$total_credit);
				$gpa = round($gpa, 2);
				
				$promotion="";
				$sess_id=0;
				$sess=Academic_session::find_session(previous_session($a_session));
				foreach($sess as $ses){
					$sess_id = $ses->id;
				}
				$statu = Student_status::find_by_stdnt($student->id, $sess_id);
				foreach($statu as $statea):
					$promotion = $statea->status;
				endforeach;
				
				
				
				//if $retrieved==1, it implies that all the results for the courses the student registered for are complete
				//if $promotion!="pending", it implies that the cgpa for the previous session has been computed
				//$num==$index implies that the number of courses registered is equal to the number of results available for the session
				
				if(1){
					$current_session = $student->session_of_entry;
					$continue=0;
					$case1="";
					while($continue!=1){
						$sesse=Academic_session::find_session($current_session);
						foreach($sesse as $sese){
							$sesi_id = $sese->id;
						}
						$status = Student_status::find_by_stdnt($student->id, $sesi_id);;
						foreach($status as $statee):
							$case1 = $statee->case_status;
						endforeach;
						if($case1=="FR" || $case1="MC"){
							$sem1=Semester::find($current_session, "first");
							foreach($sem1 as $sem){
							 $sm1_id=$sem->id;
							}
							$sem2=Semester::find($current_session, "second");
							foreach($sem2 as $sem){
							 $sm2_id=$sem->id;
							}
							$rpt=0;
							$regste = Result_sheet::find_by_sem($sm1_id, $sm2_id, $id);
							foreach($regste as $rege){
								
								$crd=0;
								
							       $corz=Course::find_by_id($rege->course_id);
							       foreach($corz as $corx){
								$crd=$corx->credit_unit;
							       }
								
								if($rege->status==1 || $rege->status==2){
								
							       $product=$crd*point(grade(total($rege->assessment,$rege->exam_score)));
							       $cum_point = $cum_point + $product;
							       $cum_credit = $cum_credit + $crd;
							       }
								
							}
						}
						//echo $current_session;
						if($current_session==$a_session) $continue=1;
						else $current_session=next_session($current_session);
					}
					$cgpa = $cum_point/$cum_credit;
					$cgpa = round($cgpa, 2);
					
					$max_year;
					$depts = Departments::find_unit($student->unit);
					foreach($depts as $dep){
						$max_year = $dep->duration;
					}
					$duration = $max_year*100;
					$max_year = ($max_year%2==0) ? $max_year*1.5 : ($max_year - 1)*1.5;
					$max_year = ($student->mode_of_entry=='direct entry') ? $max_year-- : $max_year;
					
					if($no_of_years<$max_year){
							if($promotion=="probation" && probate($cgpa)=="probation" && $no_of_years>1 || $no_reg==1){	
								$new_status = "withdrawn";	
							}else{
							if($level==$duration){
								$no_rpt=1; $all=1;
								$regis = Result_sheet::find_by_sem($sm11_id, $sm22_id, $id);
								foreach($regis as $regd){
										if(total($regd->assessment, $regd->exam_score)<40 && $regd->status==1) $no_rpt=0;	
									if($regd->status!=1) $all=0;
								}
								$takes1 = Take_courses::find_student($sm11_id, $sm22_id, $student->id);
								//$repeats = Repeat_courses::check_student($student->matric_no, $a_session);
								if(empty($takes1) && $no_rpt==1){
									$new_status = "graduated";
								}
								else{
									$new_status = probate($cgpa);
								}
							}
							if($level<$duration){
								
								if($student->level==100) $new_status = probate($gpa);
								else $new_status = probate($cgpa);	
							}
							}
					}else{
						$new_status = "graduated";	
					}
					$sees=0;
						$sesso=Academic_session::find_session($a_session);
						foreach($sesso as $sesl){
							$sees = $sesl->id;
						}
						$gp=0;
						$status = Student_status::find_by_stdnt($student->id, $sees);
						foreach($status as $stade):
						if($stade->no_of_years>1) $gp=$cgpa; else $gp=$gpa;
						Student_status::update_gp($gp, $stade->id);
						Student_status::update_status($new_status, $stade->id);
						endforeach;
					
				
				}
				$strgp=$gpa.""; 
				$gpa=conca($strgp);
				$CGPA = array();
				$CGPA[0] = $total_point;
				$CGPA[1] = $total_credit;
				$CGPA[2] = $gpa;
				$strcgp=$cgpa."";
				$cgpa=conca($strcgp);
				$CGPA[3] = $cum_point;
				$CGPA[4] = $cum_credit;
				$CGPA[5] = $cgpa;
				
				$CGPA[6] = $retrieved;
				return $CGPA;
			}
		endforeach;
	}
	?>