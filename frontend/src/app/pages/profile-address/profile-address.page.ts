import {Component, OnInit} from '@angular/core';
import {Storage} from '@ionic/storage';
import {ProviderService} from 'src/app/services/provider.service';
import {ControllersService} from 'src/app/services/controllers.service';

@Component({
    selector: 'app-profile-address',
    templateUrl: './profile-address.page.html',
    styleUrls: ['./profile-address.page.scss'],
})
export class ProfileAddressPage implements OnInit {
    formData: any = {};
    id: string;
    items: any;

    constructor(private storage: Storage, public ctrl: ControllersService,
                private providerSvc: ProviderService) {
    }

    ngOnInit() {
        this.getData();
        this.loadSelectValue();
    }

    getData() {
        this.storage.get('USER_INFO').then(data => {
            if (data != null) {
                this.id = data[0].patient_id;
                this.formData.address = data[0].patient_address;
                this.formData.city = data[0].patient_city;
                this.formData.township = data[0].patient_state;
                this.formData.zipcode = data[0].patient_zipcode;
            }
        }, error => {
            console.log(error);
        });
    }

    Save() {
        this.storage.get('USER_INFO').then(data => {
            if (data != null) {
                this.id = data[0].patient_id;
            }
        }, error => {
            console.log(error);
        });


        if (this.formData.address != null && this.formData.city != null && this.formData.township != null && this.formData.zipcode != null) {
            if (!isNaN(this.formData.zipcode) && this.formData.zipcode.length < 6) {
                const dataPost = new FormData();
                dataPost.append('inputID', this.id);
                dataPost.append('inputAddress', this.formData.address);
                dataPost.append('inputCity', this.formData.city);
                dataPost.append('inputTownship', this.formData.township);
                dataPost.append('inputZipcode', this.formData.zipcode);

                this.providerSvc.postData('profile-address.php', dataPost).subscribe(res => {
                    this.ctrl.alertPopUp('Successful', 'Updated', 'OK');
                    this.storage.set('USER_INFO', res).then((data) => {
                        this.getData();
                    });
                }, error => {
                    console.log(error);
                });
            } else {
                this.ctrl.alertPopUp('Attention', 'Zipcode only number and not exceed 5!', 'Try Again');
            }
        } else {
            this.ctrl.alertPopUp('Attention', 'All Field is Required!', 'Try Again');
        }

    }

    loadSelectValue() {
        this.providerSvc.getData('select.php').subscribe(data => {
            if (data != null) {
                this.items = data;
            }
        });
    }

}
