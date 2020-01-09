<div data-angular-module="module/angular/angular__module">

	<div ng-controller="listaSettingsController" class="cf c-settings">


        <form class="c-form">

            <div class="alert alert-success" ng-if="state == 'success'">
                Dados gravados com sucesso.
            </div>

            <div class="alert alert-danger" ng-if="state == 'error'">
                Ocorreu um erro ao gravar os dados.
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Segredo para Captcha</label>
                <input type="text" class="form-control" id="vchCaptchaSecret" ng-model="formData.vchCaptchaSecret">
                <small class="form-text text-muted">O segredo é de uso exclusivo no servidor.</small>
            </div>
            <div class="form-group">
                <label for="vchCaptchaSiteKey">Captcha site key</label>
                <input type="text" class="form-control" id="vchCaptchaSiteKey" ng-model="formData.vchCaptchaSiteKey">
                <small class="form-text text-muted">Esta key será usada para renderizar o captcha.</small>
            </div>

            <div class="form-group">
                <label for="vchFromEmail">From email</label>
                <input type="text" class="form-control" id="vchFromEmail" ng-model="formData.vchFromEmail">
                <small class="form-text text-muted">Este email será enviado no from dos emails</small>
            </div>
            <div class="form-group">
                <label for="vchFromName">From name</label>
                <input type="text" class="form-control" id="vchFromName" ng-model="formData.vchFromName">
                <small class="form-text text-muted">Este nome será usado no subject do email.</small>
            </div>
            <div class="form-group">
                <label for="vchEmailGestao">Email de gestão</label>
                <input type="text" class="form-control" id="vchEmailGestao" ng-model="formData.vchEmailGestao">
                <small class="form-text text-muted">Este email será usado para enviar um resumo dos dados enviados para backoffice.</small>
            </div>

            <button type="submit" class="btn btn-primary" ng-click="saveSettings();">Gravar</button>
        </form>

	</div>

</div>