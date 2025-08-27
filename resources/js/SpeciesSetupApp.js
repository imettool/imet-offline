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

import progressBar from "@imet-core/js/templates/progress_bar.vue";


export default class SpeciesSetupApp extends Base {

    constructor(input_data) {

        const options = {
            name: 'SpeciesSetupApp',

            props: {
                save_url: String,
                job_id: String,
            },

            setup(props, context) {

                let taskStarted = ref(false);
                let taskCompleted = ref(false);
                let taskProgress = ref(0);

                window.Native.on("App\\Events\\TaskProgressing", (payload, event) => {
                    if(payload.jobId === props.job_id){
                        updateProgress(payload.progress);
                    }
                });

                function storeDataset(){
                    let payload = {
                        _method: 'PATCH',
                        job_id: props.job_id
                    }

                    taskStarted.value = true;

                    fetch(props.save_url, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": window.Laravel.csrfToken,
                        },
                        body: JSON.stringify(payload),
                    })
                        .then()
                        .catch(function (error) {
                            console.error(error)
                        });
                }
                function updateProgress(progress){
                    progress = parseInt(progress);
                   taskProgress.value = progress;
                    if(progress >= 100){
                       taskCompleted.value = true;
                    }
                }

                return {
                    storeDataset,
                    taskStarted,
                    taskProgress,
                    taskCompleted
                }

            }

        }

        return super(options, input_data)
            .component('progressBar', progressBar);
    }
}
