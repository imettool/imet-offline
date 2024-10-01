import Base from "@modular-forms/js/apps/Base.js";

import PasCountryUpdate from "./components/PasCountryUpdate.vue";

export default class PaUpdate extends Base {

    constructor(input_data) {

        const options = {

            name: 'PaUpdate',

            setup(props, context){

                function update(iso3) {
                    console.log('update', iso3);
                }

                function download(iso3) {
                    console.log('download', iso3);
                }

                return {
                    update,
                    download
                };
            }

        }


        return super(options, input_data)
            .component('pascountryupdate', PasCountryUpdate)
    }
}
