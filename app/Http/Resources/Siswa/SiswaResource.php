<?php

namespace App\Http\Resources\Siswa;

use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->reg_number,
            'no_pendaftaran' => $this->unit->name,
            'program' => $this->join_date,
            'tanggal_daftar' => $this->semester_id?$this->semester->semester_id:'-',
            'tahun_ajaran' => $this->level_id?$this->level->level:'-',
            'nipd' => $this->student_nis,
            'nisn' => $this->student_nisn,
            'nama' => $this->student_name,
            'nama_panggilan' => $this->student_nickname,
            'tempat_lahir' => $this->birth_place,
            'tanggal_lahir' => $this->birth_date,
            'jenis_kelamin' => $this->gender_id?ucwords($this->jeniskelamin->name):'',
            'agama' => $this->religion_id?$this->agama->name:'-',
            'anak_ke' => $this->child_of,
            'status_anak' => $this->family_status,
            'alamat' => $this->address,
            'no' => $this->address_number,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'wilayah' => $this->region_id?$this->wilayah->name.', '.$this->wilayah->kecamatanName().', '.$this->wilayah->kabupatenName().', '.$this->wilayah->provinsiName():'',
            'nama_ayah' => $this->orangtua->father_name,
            'nik_ayah' => $this->orangtua->father_nik,
            'hp_ayah' => $this->orangtua->father_phone,
            'email_ayah' => $this->orangtua->father_email,
            'pekerjaan_ayah' => $this->orangtua->father_job,
            'jabatan_ayah' => $this->father_position,
            'telp_kantor_ayah' => $this->orangtua->father_phone_office,
            'alamat_kantor_ayah' => $this->orangtua->father_job_address,
            'gaji_ayah' => $this->orangtua->father_salary,
            'nama_ibu' => $this->orangtua->mother_name,
            'nik_ibu' => $this->orangtua->mother_nik,
            'hp_ibu' => $this->orangtua->mother_phone,
            'email_ibu' => $this->orangtua->mother_email,
            'pekerjaan_ibu' => $this->orangtua->mother_job,
            'jabatan_ibu' => $this->mother_position,
            'telp_kantor_ibu' => $this->orangtua->mother_phone_office,
            'alamat_kantor_ibu' => $this->orangtua->mother_job_address,
            'gaji_ibu' => $this->orangtua->mother_salary,
            'nip_ortu' => $this->orangtua->employee_id,
            'alamat_ortu' => $this->orangtua->parent_address,
            'hp_alternatif' => $this->orangtua->parent_phone_number,
            'nama_wali' => $this->orangtua->guardian_name,
            'nik_wali' => $this->orangtua->guardian_nik,
            'hp_wali' => $this->orangtua->guardian_phone,
            'email_wali' => $this->orangtua->guardian_email,
            'pekerjaan_wali' => $this->orangtua->guardian_job,
            'jabatan_wali' => $this->guardian_position,
            'telp_kantor_wali' => $this->orangtua->guardian_phone_office,
            'alamat_kantor_wali' => $this->orangtua->guardian_job_address,
            'gaji_wali' => $this->orangtua->guardian_salary,
            'alamat_wali' => $this->orangtua->guardian_address,
            'asal_sekolah' => $this->origin_school.', '.$this->origin_school_address,
            'saudara_kandung' => $this->sibling_name?$this->sibling_name:'-',
            'nama_saudara' => $this->sibling_level_id?$this->levelsaudara->level:'-',
            'info_dari' => $this->info_from,
            'info_dari_nama' => $this->info_name,
            'info_dari_posisi' => $this->position,
            'class_id' => $this->class_id,
        ];
    }
}
