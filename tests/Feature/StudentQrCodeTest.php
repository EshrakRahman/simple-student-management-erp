<?php

use App\Models\Student;

beforeEach(function () {
    $this->student = Student::factory()->create();
});

test('qr code page loads for a student', function () {
    $response = $this->get(route('filament.admin.resources.students.qrCode', $this->student));

    $response->assertStatus(200);
    $response->assertSee($this->student->name);
    $response->assertSee('Student QR Code');
});

test('qr code contains student information', function () {
    $response = $this->get(route('filament.admin.resources.students.qrCode', $this->student));

    $response->assertStatus(200);
    $response->assertSee($this->student->email);
    $response->assertSee('QR Code Data');
});
