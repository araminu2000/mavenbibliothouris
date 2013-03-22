<?php

class Application_CoursesDbTest extends Zend_Test_PHPUnit_ControllerTestCase 
{
	protected $_db;
	
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
		
		$this->_db = Zend_Registry::get('dbBibliothouris');
    }
	
	protected function _callConstraintsCheckSql($fkName = null, $fkType = null, $tableName = null, $dbName = null) 
	{	
		if(!isset($fkName, $fkType, $tableName, $dbName)) {
			return false;
		}
		
		$query = "
			SELECT 
				(
					CASE 
						WHEN COUNT(*)= 1 
							THEN 'OK'
						ELSE 'NOK'
					END
				)
				
				AS testResult 
				
				FROM `information_schema`.`TABLE_CONSTRAINTS` TC 
				
				WHERE TC.CONSTRAINT_NAME 	= '{$fkName}'
				AND TC.CONSTRAINT_TYPE 		= '{$fkType}'
				AND TC.TABLE_SCHEMA 		= '{$dbName}'
				AND TC.TABLE_NAME 			= '{$tableName}'		
		";
		
		
		$stmt = $this->_db->query($query);
		$data = $stmt->fetchAll();
		
		if (isset($data[0]) && isset($data[0]['testResult'])) {
			return $data[0]['testResult'];
		}
		
		return false;
	}
	
	/* Members */
	
	public function test_Db_PrimaryKeyExistsAndIsForeginKeyOnMembersTable() 
	{		
		$check = $this->_callConstraintsCheckSql('PRIMARY', 'PRIMARY KEY', 'members', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
	
	
	/* Courses */
	
	public function test_Db_PrimaryKeyExistsAndIsForeginKeyOnCoursesTable() 
	{		
		$check = $this->_callConstraintsCheckSql('PRIMARY', 'PRIMARY KEY', 'courses', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
	
	/* Enrollments */
	
	public function test_Db_FkEnrollCourseIdExistsAndIsForeginKeyOnCoursesFeedbackTable() 
	{		
		$check = $this->_callConstraintsCheckSql('FK_ENROLL_COURSEID', 'FOREIGN KEY', 'enrollments', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
	
	public function test_Db_FkEnrollMemmberIdExistsAndIsForeginKeyOnCoursesFeedbackTable() 
	{		
		$check = $this->_callConstraintsCheckSql('FK_ENROLL_MEMBERID', 'FOREIGN KEY', 'enrollments', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
	
	/* Courses FeedBack */
	
	public function test_Db_PrimaryKeyExistsAndIsForeginKeyOnCoursesFeedbackTable() 
	{		
		$check = $this->_callConstraintsCheckSql('PRIMARY', 'PRIMARY KEY', 'courses_feedback', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
	
	public function test_Db_FkCourseIdExistsAndIsForeginKeyOnCoursesFeedbackTable() 
	{		
		$check = $this->_callConstraintsCheckSql('FK_COURSEID', 'FOREIGN KEY', 'courses_feedback', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
	
	public function test_Db_FkMemberIdExistsAndIsForeginKeyOnCoursesFeedbackTable() 
	{		
		$check = $this->_callConstraintsCheckSql('FK_MEMBERID', 'FOREIGN KEY', 'courses_feedback', 'bibliothouris');
		$this->assertEquals('OK', $check);
	}
}

?>