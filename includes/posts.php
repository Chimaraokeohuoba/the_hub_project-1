<?php
    #This file was created on 10-NOV-2018  :  11:49pm CAT
    #Author: Ohuoba Chimaraoke
    #File name: posts.php
    #File type: PHP
    #Description:
    /*The purpose of this script is to create, process, access and manage item posts */


    require "datacontrol.php" ;
    $baseData = new Database("thehub");


    class posts{
        private $table = 'posts';
        protected $id;
        protected $name;
        protected $votes;
        protected $creator;
        protected $category;
        protected $photo;
        protected $date;
        protected $baseData;

        function __construct(){
            global $baseData;
            $this->baseData = $baseData;
        }



        function appendToHTML(){

            $html = ' <div class="container">
            <div class="jumbotron shard" id = "first_vote">
            <div class="row">
            <a href="/vote/Samsung-970-EVO-Massdrop">
            <div>
              <h4>'.$this->getName().'</h4>

                <div class="poll_card__author"><span>– </span>by
              <a class="user__name" href="/profile/Nerdtality/polls"><strong>'.$this->getCreator().'</strong></a></div>

            </div>
              <div class="col-lg-3 col-md-3 col-sm-3">

                      <div>

                                <img class = " img-responsive" alt="'.$this->getName().'" src="'.$this->getPhoto().'" class="responsive poll_card__img">

                              <div ></div>
                              <div>
                              </div>
                      </div>
                    </div>


              <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="poll_card__options_heading"><h4>Options</h4></div>
                <div class="poll_card__votes">




              <button type="button" name="button"><span class="poll_card__more_options_button button button--large link_button--primary">+1 Other Option</span></button>

            </div>
          </div>
          </a>
        </div>
      </div>
    </div>
';
            echo $html;
        }


        #------------------Setter functions
        function setId($id){
            $this->id = $id;
        }

        function setName($name){
            $this->name = $name;
        }

        function setVotes($votes){
            $this->votes = $votes;
        }

        function setCreator($creator){
            $this->creator = $creator;
        }

        function setCategory($category){
            $this->category = $category;
        }

        function setPhoto($photo){
            $this->photo = $photo;
        }

        function setDate($date){
            $this->date = $date;
        }



        #------------------Getter functions

        /**
        * @ this function gets a post record from database and uses the record to create a post object and returns the object
        */
        public static function getPostById($id){
            global $baseData;
            $record = $baseData->getRecordRow("posts","id",$id);
            $post = new posts();
            $post->setId($record['id']);
            $post->setName($record['name']);
            $post->setVotes($record['votes']);
            $post->setCreator($record['creator']);
            $post->setPhoto($record['photo_url']);
            $post->setCategory($record['category']);
            $post->setDate($record['date']);
            return $post;



        }

        public function sortPostOptions($postOptions){
            #an algorithm that sorts post options according to their number of votes
            $sortedOptions = Array();
            $votes = Array();
            $count = 0;
            #loop through all the post option objects, get their votes and add them to $votes array
            foreach ($postOptions as $option){
                $votes[$count] = $option->getVotes();
                $count++;
            }
            #sort the votes array in descending order of their value
            rsort($votes);
            /*loop through the $votes array, get the post option object that matches with the current vote index
             * and add it to the $sortedOptions array at current index
             */
            for ($x=0; $x<count($votes); $x++){
                foreach ($postOptions as $option){
                    if ($option->getVotes()==$votes[$x]){
                        $option->setPriority($x+1); #set the priority of the option (this determines the position where the option will placed in the list of options)
                        $sortedOptions[$x] = $option; #add option to $sortedOptions
                    }
                }

            }
            # return the $sortedOptions array
            return $sortedOptions;
        }

        public function getPostOptions(){
            #this function gets a post options from the database, build them into an object and return an array of the Objects
            $options = Array();
            #read the post options from the database and store it as an array in $records
            $records = $this->baseData->getMultipleRecords('items', 'foreign_key', $this->id);
            if ($records != NULL){
                #make sure that $records data is not NULL
                #if $records is NULL that implies that there was no option for the post found in database
                $recordLength = count($records);
                for ($x=0; $x<$recordLength; $x++){
                    #loop through all the option records read from the database
                    $option = new Option(); #create a new option object
                    # $option->setSortKey('key'.rand()); //has no need for now
                    $option->setAllVars($records[$x]); #set all the properties of the option object with $records array
                    $options[$x]=$option; # add the option object to $options array
                }
                $options = $this->sortPostOptions($options); #sort the post options
                return $options;

            }else {
                #return NULL since the $records NULL (No data read from database)
                return NULL;
            }


        }


        /**
        * @return the $votes
        */
        function getName(){
            return $this->name;
        }

        /**
         * @return the $votes
         */
        public function getVotes()
        {
            return $this->votes;
        }

        /**
        * @return the $creator
        */
        public function getCreator()
        {
            return $this->creator;
        }

        /**
        * @return the $category
        */
        public function getCategory()
        {
            return $this->category;
        }

        /**
        * @return the $photo
        */
        public function getPhoto()
        {
            return $this->photo;
        }

        /**
        * @return the $date
        */
        public function getDate()
        {
            return $this->date;
        }


        #end of class
    }




    class Option extends posts{
        private $table = 'items';
        protected $id;
        protected $name;
        protected $votes;
        protected $photo;
        protected $creator;
        protected $category;
        protected $group;
        protected $key;
        protected $date;
        protected $sortKey;
        protected $priority;
        protected $baseData;


        function __construct(){
            global $baseData;
            $this->baseData = $baseData;

        }


        /**
         * @param field_type $priority
         */
        public function setPriority($priority)
        {
            $this->priority = $priority;
        }

        #-----------Getters


        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return the $name
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @return the $votes
         */
        public function getVotes()
        {
            return $this->votes;
        }

        /**
         * @return the $photo
         */
        public function getPhoto()
        {
            return $this->photo;
        }

        /**
         * @return the $creator
         */
        public function getCreator()
        {
            return $this->creator;
        }

        /**
         * @return the $category
         */
        public function getCategory()
        {
            return $this->category;
        }

        /**
         * @return the $group
         */
        public function getGroup()
        {
            return $this->group;
        }

        /**
         * @return the $key
         */
        public function getKey()
        {
            return $this->key;
        }

        /**
         * @return the $date
         */
        public function getDate()
        {
            return $this->date;
        }

        /**
         * @return the $sortKey
         */
        public function getSortKey()
        {
            return $this->sortKey;
        }


        #--------------Setters


        /**
         * @param field_type $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @param field_type $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @param field_type $votes
         */
        public function setVotes($votes)
        {
            $this->votes = $votes;
        }

        /**
         * @param field_type $photo
         */
        public function setPhoto($photo)
        {
            $this->photo = $photo;
        }

        /**
         * @param field_type $creator
         */
        public function setCreator($creator)
        {
            $this->creator = $creator;
        }

        /**
         * @param field_type $category
         */
        public function setCategory($category)
        {
            $this->category = $category;
        }

        /**
         * @param field_type $group
         */
        public function setGroup($group)
        {
            $this->group = $group;
        }

        /**
         * @param field_type $key
         */
        public function setKey($key)
        {
            $this->key = $key;
        }

        /**
         * @param field_type $date
         */
        public function setDate($date)
        {
            $this->date = $date;
        }

        /**
         * @param field_type $sortKey
         */
        public function setSortKey($sortKey)
        {
            $this->sortKey = $sortKey;
        }

        /**
         * @sets all variables in this class with an array passed as parameter
         */
        public function setAllVars($blockData){
            $this->setId($blockData['id']);
            $this->setName($blockData['name']);
            $this->setVotes($blockData['votes']);
            $this->setCreator($blockData['creator']);
            $this->setCategory($blockData['category']);
            $this->setPhoto($blockData['photo_url']);
            $this->setGroup($blockData['item_group']);
            $this->setKey($blockData['foreign_key']);
            $this->setDate($blockData['date']);
        }

        public function getPriority(){
            return $this->priority;

        }

        function getPriorityString(){
            if ($this->priority == 1){
                return 'first';
            }elseif ($this->priority == 2){
                return 'second';
            }elseif ($this->priority == 3){
                return 'third';
            }elseif ($this->priority == 4){
                return 'fourth';
            }else{
                return 'fourth';
            }
        }


        public function appendHTML(){

        }

        public function vote(){
            $vote = $this->baseData->getRecord('items', 'votes', 'id', $this->id);
            $vote++; #increment the votes
            $success = $this->baseData->updateRecord($this->table, 'votes', $vote, 'id', $this->id);
            if ($success){
                return TRUE;
            }else {
                return FALSE;
            }
        }

    }



    $post = posts::getPostById("1");
    //echo $post->getPostOptions()[0]->getName();
    if ($post->getPostOptions()[0]->vote()){
        echo 'voted for '.$post->getPostOptions()[0]->getName();
    }











?>