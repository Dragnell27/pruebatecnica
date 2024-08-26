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

  //Declaro las opciones de Idiomas.
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

  //Declaración del constructor para el cambio de idioma
  constructor(private translateService: TranslateService) {

  }

  //Detecta si hubo cambios en el selector de idioma y cambia el json de traducción a usar
  changeLanguage(event: Event){
    if (event.target) {
      const changeEvent = event.target as HTMLInputElement;
      this.translateService.use(changeEvent.value)
    }
  }

}
