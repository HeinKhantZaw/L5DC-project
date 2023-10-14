import {Component, OnInit} from '@angular/core';
import {Storage} from '@ionic/storage';
import {ProviderService} from 'src/app/services/provider.service';
import {Router} from '@angular/router';

@Component({
    selector: 'app-home',
    templateUrl: './home.page.html',
    styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {
    items: any;
    patientID: any;
    patientFirstname: any;
    itemsApp: any;
    imgURL: string;

    clinicID: any;
    doctorID: string;
    appDate: any;
    appTime: any;
    doctorName: string;
    Speciality: string;
    doctorAvatar: string;
    appointmentID: string;

    empty: number;

    constructor(private storage: Storage, private providerSvc: ProviderService, private router: Router) {
    }

    ngOnInit() {
        this.getData();
    }

    getData() {
        this.storage.get('USER_INFO').then(data => {
            if (data != null) {
                this.items = data;
                this.patientID = data[0].patient_id;
                this.patientFirstname = data[0].patient_firstname;
                this.getAppointmentData(this.patientID);
                this.imgURL = this.providerSvc.imgURL;
            }
        }, error => {
            console.log(error);
        });
    }

    getAppointmentData(patientID: number) {
        const postData = JSON.stringify({
            patientID: this.patientID
        });
        this.providerSvc.postData('appointment-list.php', postData).subscribe(appdata => {
            if (appdata != null) {
                this.appointmentID = appdata[0].app_id;
                this.clinicID = appdata[0].clinic_id;
                this.doctorID = appdata[0].doctor_id;
                this.doctorName = appdata[0].doctor_firstname + ' ' + appdata[0].doctor_lastname;
                this.doctorAvatar = appdata[0].doctor_avatar;
                this.appDate = appdata[0].app_date;
                this.appTime = appdata[0].app_time;
                this.Speciality = appdata[0].speciality_name;
                this.empty = 0;
            } else {
                this.empty = 1;
                console.log('No Data Available');
            }
        }, error => {
            console.log('Load Failed', error);
        });
    }

    appointmentProfile(id: number) {
        this.router.navigate(['appointment-view', id]);
    }
}
