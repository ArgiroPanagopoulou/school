<?php
namespace School\UserBundle\Form\Model;

class TeacherAssignation
{
    public $schoolyear;
    
    public $courses;
    
    public $schoolClasses;
    
    public $teacher;
    
    
    public function addCourse(\School\UserBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }
    
    public function getCourses()
    {
        return $this->courses;
    }
    
    public function setSchoolYear(\School\UserBundle\Entity\SchoolYear $schoolyear = null)
    {
        $this->schoolyear = $schoolyear;
        return $this;
    }
    
    public function getSchoolYear()
    {
        return $this->schoolyear;
    }
    
    public function addSchoolClass(\School\UserBundle\Entity\SchoolClass $schoolClasses)
    {
        $this->schoolClasses[] = $schoolClasses;

        return $this;
    }

    /**
     * Remove schoolClasses
     *
     * @param \School\UserBundle\Entity\SchoolClass $schoolClasses
     */
    public function removeSchoolClass(\School\UserBundle\Entity\SchoolClass $schoolClasses)
    {
        $this->schoolClasses->removeElement($schoolClasses);
    }

    /**
     * Get schoolClasses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchoolClasses()
    {
        return $this->schoolClasses;
    }
    
    /**
     * Set teacher
     *
     * @param \School\UserBundle\Entity\Teacher $teacher
     * @return CourseClass
     */
    public function setTeacher(\School\UserBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \School\UserBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}