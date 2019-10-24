<div data-angular-module="module/angular/angular__module">

	<div ng-controller="listaCandidaturasController" class="cf" dir-List-Pager="candidaturas">

		<div class="l-filtros cf">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary" ng-click="setState('todos');">Todos</button>
				<button type="button" class="btn btn-primary" ng-click="setState('arquivo');">Arquivo</button>
			</div>
		</div><!-- filtros -->

		<h2 ng-if="state == 'todos'">Todos</h3>
		<h2 ng-if="state == 'arquivo'">Arquivo</h3>

		<div class="l-filtros cf">
			<select name="filtro_oferta_id" ng-model="filtro_oferta_id" class="form-control" ng-change="filtraCandidaturas();">
				<option value="" disabled>Filtrar por oferta...</option>
				<option value="">Ver todos</option>
				<option value="{{item.ID}}" ng-repeat="item in ofertasEmprego">{{item.post_title}} ({{item.candidaturas_num}})</option>
			</select>
		</div><!-- filtros -->

		<div class="contact__list cf">
			<div class="panel panel-default" dir-Open-Panel ng-class="{'delleting' : item.delleting, 'open': candidaturaSelectedId == item.iIDCandidatura}" ng-repeat="item in candidaturas | startFrom:currentPage*(pageSize) | limitTo:pageSize+1" style="width:90%;">
				<div class="panel-heading">
					<h2 class="panel-title"><span ng-if="item.iIDPost != 0">{{item.vchPostTitle}} - </span>{{item.vchNome}} {{item.vchApelido}}
						<div style="float:right;">{{getDate(item.iData)}}</div>
					</h2>
				</div>
				<div class="panel-body">
					<div class="controlls">
						<button type="button" class="btn btn-warning" ng-click="arquivarCandidatura(item.iIDCandidatura)" ng-if="!item.delleting && item.iEstado == '1'">Arquivar</button>
						<button type="button" class="btn btn-success" ng-click="restaurarCandidatura(item.iIDCandidatura)" ng-if="!item.delleting && item.iEstado == '2'">Restaurar</button>
						<button type="button" class="btn btn-danger" ng-click="deleteCandidatura(item.iIDCandidatura)" ng-if="!item.delleting">Apagar</button>
					</div>
					<div class="mb_5"><b><a href="mailto:{{item.vchEmail}}">{{item.vchEmail}}</a></b></div>
					<font style="font-size:12px;">
						<b>Telefone: </b>{{item.vchTelefone}}<br />
						<b>Autorização tratamento dados: </b>{{item.iAutorizacao}}<br />
					</font>
					<p>{{item.vchMensagem}}</p>
					<p><a href="{{pluginsDir}}/file.php?id={{item.iIDCandidatura}}" target="_blank">Curriculum Vitae</a></p>
				</div>
			</div>
		</div>

		<nav aria-label="Page navigation" ng-show="numberOfPages() > 1">
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

		<ul class="list-group" style="width:90%;" ng-if="candidaturas.length == 0">
		  <li class="list-group-item">
    		Não existem registos a apresentar.
		  </li>
		</ul>

	</div>

</div>