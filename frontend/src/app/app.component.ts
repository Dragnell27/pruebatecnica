import { Component, OnInit } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { LanguageComponent } from './components/language/language.component';
import { TranslateModule } from '@ngx-translate/core';
import { LocationComponent } from './components/location/location.component';
import { environment } from '../environments/environment';
import { DecimalPipe } from '@angular/common';

declare var $: any;

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,DecimalPipe, LanguageComponent, TranslateModule, LocationComponent,RouterOutlet, RouterLink, RouterLinkActive],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {
  countries: any[] = [];
  private endPoint = environment.apiUrl;

  ngOnInit(): void {
    $.ajax({
      url: `${this.endPoint}/history_show`,
      method: 'GET',
      success: (data: any) => {
        this.countries = data.data;
      },
      error: (jqXHR: any, textStatus: string, errorThrown: string | Error) => {
        console.error('Error:', textStatus, errorThrown);
      }
    });
  }

  history(event: Event) {
    if (event.target) {
      event.preventDefault();
      const history = document.getElementById('history');

      if (history) {
        history.classList.toggle('d-none');
      }
    }
  }
}
