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

import {reactive, ref, watch, toRaw} from "vue";

import uploadFile from "@modular-forms/js/inputs/upload.vue";
import progressBar from "@imet-core/js/templates/progress_bar.vue";


export default class ProtectedPlanetUploadApp extends Base {

    constructor(input_data) {

        const options = {
            name: 'ProtectedPlanetUploadApp',

            props: {
                records: Object,
                save_url: String,
                progress_url: String,
            },

            setup(props, context) {

                let records = reactive(props.records)
                let uploaded = ref(false);
                let jobId = ref(null);
                let storeStarted = ref(false);
                let storeCompleted = ref(false);
                let storeProgress = ref(0);

                const Payload = window.ModularForms.Helpers.Payload;

                watch(records, () => {
                    toggleUploaded();
                });

                function toggleUploaded(){
                    uploaded.value = records['dataset_upload']['temp_filename'] !== null;
                }

                function storeDataset(){

                    let payload = {
                        _method: 'PATCH',
                        records:  Payload.encode(records),
                    }

                    fetch(props.save_url, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": window.Laravel.csrfToken,
                        },
                        body: JSON.stringify(payload),
                    })
                        .then((response) => response.json())
                        .then(function(data){
                            if (data.status === 'success') {
                                jobId.value = data.jobId;
                                storeStarted.value = true;
                                pollProgress(toRaw(jobId.value));
                            }
                        })
                        .catch(function (error) {
                            console.error(error)
                        });
                }

                function pollProgress(jobId){

                    const intervalHandle = setInterval(() => {
                        fetch(props.progress_url.replace('xxxx', jobId), {
                            method: 'GET',
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-Token": window.Laravel.csrfToken,
                            },
                        })
                            .then((response) => response.json())
                            .then(function(data){
                                let progress = parseInt(data);
                                storeProgress.value = progress;
                                if(progress >= 100){
                                    storeCompleted.value = true;
                                    clearInterval(intervalHandle);
                                }
                            })
                            .catch(function (error) {
                                console.error(error)
                            });
                    }, 1000);
                }

                return {
                    records,
                    uploaded,
                    storeDataset,
                    storeStarted,
                    storeProgress,
                    storeCompleted
                }

            }

        }

        return super(options, input_data)
            .component('upload', uploadFile)
            .component('progressBar', progressBar);
    }
}
