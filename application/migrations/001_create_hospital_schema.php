<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Hospital_Schema extends CI_Migration {

    public function up() {
        log_message('error', 'Running Migration: Create_Hospital_Schema');

        // Create User table
        $this->dbforge->add_field([
            'ID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'Email' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Password' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Name' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Role' => [
                'type' => 'ENUM',
                'constraint' => ['Admin', 'Doctor']
            ],
            'CreatedAt' => [
                'type' => 'DATETIME'
            ],
            'UpdatedAt' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->create_table('User');

        // Create Patient table
        $this->dbforge->add_field([
            'ID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'RecordNumber' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'Name' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Birth' => [
                'type' => 'DATE'
            ],
            'NIK' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'Phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15'
            ],
            'Address' => [
                'type' => 'TEXT'
            ],
            'BloodType' => [
                'type' => 'ENUM',
                'constraint' => ['A', 'B', 'AB', 'O']
            ],
            'Weight' => [
                'type' => 'FLOAT'
            ],
            'Height' => [
                'type' => 'FLOAT'
            ],
            'CreatedAt' => [
                'type' => 'DATETIME'
            ],
            'UpdatedAt' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->add_key('RecordNumber', FALSE);
        $this->dbforge->create_table('Patient');

        // Create PatientHistory table
        $this->dbforge->add_field([
            'ID' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'RecordNumber' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'DateVisit' => [
                'type' => 'DATETIME'
            ],
            'RegisteredBy' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
            'ConsultationBy' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
            'Symptoms' => [
                'type' => 'TEXT'
            ],
            'DoctorDiagnose' => [
                'type' => 'TEXT'
            ],
            'ICD10Code' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'ICD10Name' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'isDone' => [
                'type' => 'BOOLEAN'
            ]
        ]);
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->create_table('PatientHistory');

        // Add foreign keys
        $this->db->query("ALTER TABLE PatientHistory ADD CONSTRAINT fk_recordnumber FOREIGN KEY (RecordNumber) REFERENCES Patient(RecordNumber) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE PatientHistory ADD CONSTRAINT fk_registeredby FOREIGN KEY (RegisteredBy) REFERENCES User(ID) ON DELETE SET NULL ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE PatientHistory ADD CONSTRAINT fk_consultationby FOREIGN KEY (ConsultationBy) REFERENCES User(ID) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down() {
        // Drop tables
        $this->dbforge->drop_table('PatientHistory', TRUE);
        $this->dbforge->drop_table('Patient', TRUE);
        $this->dbforge->drop_table('User', TRUE);
    }
}
