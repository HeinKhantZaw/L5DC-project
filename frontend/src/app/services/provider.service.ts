import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';

// change your server name here
const SERVER_NAME = 'http://localhost';
const API_URL = SERVER_NAME + '/lifecare/backend/patient/';
const IMG_URL = SERVER_NAME + '/lifecare/backend/uploads/';
const EMPTYIMG_URL = SERVER_NAME + '/lifecare/backend/patient/uploads/empty/empty-avatar.jpg';
const ICON_URL = SERVER_NAME + '/lifecare/backend/uploads/icons/';
const LOGIN_URL = SERVER_NAME + '/lifecare/backend/patient/login.php';

@Injectable({
    providedIn: 'root'
})

export class ProviderService {
    items: any;
    imgURL: string = IMG_URL;
    emptyURL: string = EMPTYIMG_URL;
    iconURL: string = ICON_URL;
    loginURL: string = LOGIN_URL;

    constructor(private http: HttpClient) {
    }

    postData(pathURL: string, dataPost: any) {
        return this.http.post(API_URL + pathURL, dataPost);
    }

    getData(getpathURL: string) {
        return this.http.get(API_URL + getpathURL);
    }
}
