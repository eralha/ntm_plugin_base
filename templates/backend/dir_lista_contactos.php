<div data-angular-module="module/angular/angular__module">

	<div ng-controller="listaContactosController" class="cf contact__list" dir-List-Pager="contacts">

		<div class="l-filtros cf">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary" ng-click="setState('todos');">Todos</button>
				<button type="button" class="btn btn-primary" ng-click="setState('arquivo');">Arquivo</button>
			</div>
		</div><!-- filtros -->

		<h2 ng-if="state == 'todos'">Todos</h3>
		<h2 ng-if="state == 'arquivo'">Arquivo</h3>

		<div class="panel panel-default" dir-Open-Panel ng-class="{'delleting' : contact.delleting}" ng-repeat="contact in contacts" style="width:90%;">
		  <div class="panel-heading">
		    <h2 class="panel-title">{{contact.vchNome}} - {{contact.vchEmpresa}}
		    	<div style="float:right;">{{getDate(contact.iData)}}</div>
		    </h2>
		  </div>
		  <div class="panel-body">
				<div class="controlls">
					<button type="button" class="btn btn-warning" ng-click="arquivarContact(contact.iIDContacto)" ng-if="!contact.delleting && contact.iEstado == '1'">Arquivar</button>
					<button type="button" class="btn btn-success" ng-click="restaurarContact(contact.iIDContacto)" ng-if="!contact.delleting && contact.iEstado == '2'">Restaurar</button>
					<button type="button" class="btn btn-danger" ng-click="deleteContact(contact.iIDContacto)" ng-if="!contact.delleting">Apagar</button>
				</div>
		    <b><a href="mailto:{{contact.vchEmail}}">{{contact.vchEmail}}</a></b><br />
		    <p>{{contact.vchMensagem}}</p>
		  </div>
		</div>

		<ul class="list-group" style="width:90%;" ng-if="contacts.length == 0">
		  <li class="list-group-item">
    		Não existem contactos a apresentar.
		  </li>
		</ul>

		<nav aria-label="Page navigation" ng-if="numberOfPages() > 1">
			<ul class="pagination">
				<li>
					<a href="#" aria-label="Previous" ng-click="prevPage();">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>
				<li><a>{{currentPage+1}}/{{numberOfPages()}}</a></li>
				<li>
					<a href="#" aria-label="Next" ng-click="nextPage();">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>
			</ul>
		</nav>

	</div>

</div>