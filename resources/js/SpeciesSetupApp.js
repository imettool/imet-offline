/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
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
