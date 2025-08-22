/*
 * Copyright (C) 2025 European Union
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * EUROPEAN UNION PUBLIC LICENCE v. 1.2 as published by the European Union.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the EUROPEAN UNION PUBLIC LICENCE v. 1.2 for
 * further details. You should have received a copy of the EUROPEAN UNION PUBLIC LICENCE v. 1.2. along with this program.
 * If not, see <https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12 >.
 */

import Base from "@modular-forms/js/apps/Base.js";

import {reactive, ref, watch} from "vue";

import uploadFile from "@modular-forms/js/inputs/upload.vue";


export default class ProtectedPlanetUploadApp extends Base {

    constructor(input_data) {

        const options = {
            name: 'ProtectedPlanetUploadApp',

            props: {
                records: Object,
                save_url: String,
            },

            setup(props, context) {

                let records = reactive(props.records)
                let uploaded = ref(false);

                const Payload = window.ModularForms.Helpers.Payload;

                watch(records, () => {
                    toggleUploaded();
                });

                function toggleUploaded(){
                    uploaded.value = records['dataset_upload']['temp_filename'] !== null;
                }

                function storeDataset(){

                    let data = {
                        _method: 'PATCH',
                        records:  Payload.encode(records),
                    }

                    fetch(props.save_url, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": window.Laravel.csrfToken,
                        },
                        body: JSON.stringify(data),
                    })
                        .then((response) => response.json())
                        .then(function(data){
                            if (data.status === 'success') {
                                console.log(data)
                            }
                        })
                        .catch(function (error) {
                            console.log(data)
                        });
                }

                return {
                    records,
                    uploaded,
                    storeDataset
                }

            }

        }

        return super(options, input_data)
            .component('upload', uploadFile);
    }
}
