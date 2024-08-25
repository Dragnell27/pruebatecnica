import { TranslateService } from '@ngx-translate/core';
import { Component } from '@angular/core';

@Component({
  selector: 'app-language',
  standalone: true,
  imports: [],
  templateUrl: './language.component.html',
  styleUrl: './language.component.css'
})

export class LanguageComponent {
  public locales = [
    {
      value : 'es',
      name : 'Español'
    },
    {
      value : 'de',
      name : 'Alemán'
    }
  ]

  constructor(private translateService: TranslateService) {

  }

  changeLanguage(event: Event){
    if (event.target) {
      const changeEvent = event.target as HTMLInputElement;
      this.translateService.use(changeEvent.value)
    }
  }

}
