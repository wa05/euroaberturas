<template>
  <q-page padding>
			
		<h3>{{title}}</h3>

		<div class="row">
			<div class="col-8">
				<table class="full-width">
					<thead>
						<tr>
							<th class="q-pa-md">Nombre</th>
							<th class="q-pa-md">Edad</th>
							<th class="q-pa-md">Color</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="perro in dogs">
							<td class="q-pa-md">
							  <i> {{ perro.name}}</i>
							</td>
							<td class="q-pa-md">
								<strong>	{{ perro.age }}</strong>
							</td>
							<td class="q-pa-md">
								<strong>	{{ perro.colour }}</strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-4 bg-blue">
				<form action="#">
					<!-- <q-input label="name" /> -->
					<input type="text" placeholder="name" v-model="newDog.name"><br><br>
					<input type="number" placeholder="age" v-model="newDog.age"><br><br>
					<input type="text" placeholder="colour" v-model="newDog.colour"><br><br>
          <button type="button" @click="sum">Guardar</button>
				</form>
			</div>
		</div>
		

  </q-page>
</template>

<script>
// import { QInput } from 'quasar'

export default {
	components: {
		// QInput
	},
  name: 'Test',
  data() {
  	return {
  		title: 'Listado de perros',
  		newTitle: null,
  		newDog: {
          name:null,
          age:null,
          colour:null
  		},
  		dogs: [
  			{
  				name: 'Luchi',
  				age: 5,
  				colour: 'orange'
  			},
  			{
  				name: 'Suli',
  				age: 7,
  				colour: 'brown'
  			},
  			{
  				name: 'Chiqui',
  				age: 10,
  				colour: 'white'
  			},
  		]
  	}
  },
  methods: {
  	sum() {
  		if (this.newDog.name===null || this.newDog.age===null || this.newDog.colour===null) {
  			return
  		}

  		this.dogs.push(this.newDog)
  		this.newDog= {
          name:null,
          age:null,
          colour:null
  		}
  	}
  }
}
</script>

<style scoped>
	th,td, tr {
		border: 1px solid grey;
	}
	thead tr {
		border: 2px solid black;
	}
</style>