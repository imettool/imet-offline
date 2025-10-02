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

import {reactive, ref, watch, toRaw, onMounted, nextTick} from "vue";

import simpleText from "@modular-forms/js/inputs/simple-text.vue";
import simplePassword from "@modular-forms/js/inputs/simple-password.vue";

export default class UserProfileApp extends Base {

    constructor(input_data) {

        const options = {
            name: 'UserProfileApp',

            props: {
                records: Object,
                module_key: String,
                save_url: String,
            },

            setup(props, context){

                let records = reactive(props.records);
                let records_backup = JSON.parse(JSON.stringify(toRaw(records)));
                let status = ref('init'); // "init" state avoid watch() on records during initialization
                let warning_on_save = null;
                let error_messages = ref([]);

                const Payload = window.ModularForms.Helpers.Payload;

                watch(records, (value) => {
                    if (status.value !== 'init' && status.value !== 'changed'){
                        status.value = 'changed';
                    }
                });

                onMounted(() => {
                    status.value = 'idle';
                    if(isAlreadyComplete()){
                        status.value = 'complete';
                    }
                });

                function isAlreadyComplete(){
                    return records.name !== null &&
                        records.organisation !== null &&
                        records.function !== null &&
                        records.country !== null;
                }

                function resetModule(){
                   replaceRecords(records_backup);
                    nextTick().then(() => {
                        status.value = 'idle';
                    });
                }

                function saveModule(){
                    status.value = 'saving';

                    let data = {
                        records_json: Payload.encode(records),
                        module_key: props.module_key,
                        _method: 'PATCH'
                    }
                    error_messages.value = [];

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
                                replaceRecords(data.records);
                                replaceRecordsBackup(data.records);
                                nextTick().then(() => {
                                    status.value = 'saved';
                                });
                                if('redirect_to' in data && data.redirect_to !== null) {
                                    window.location.href = data.redirect_to;
                                }
                            } else if(data.status === 'validation_error') {
                                status.value = 'error';
                                error_messages.value = data.errors;
                            }
                        })
                        .catch(function (error) {
                            status.value = 'error';
                        });
                }

                function replaceRecords(newRecords){
                    Object.entries(newRecords).forEach(([key, value]) => {
                        records[key] = JSON.parse(JSON.stringify(value));
                    });
                }
                function replaceRecordsBackup(newRecords){
                    Object.entries(newRecords).forEach(([key, value]) => {
                        records_backup[key] = JSON.parse(JSON.stringify(value));
                    });
                }

                return {
                    records,
                    status,
                    warning_on_save,
                    error_messages,
                    resetModule,
                    saveModule
                }

            }
        }

        return super(options, input_data)
            .component('simpleText', simpleText)
            .component('simplePassword', simplePassword);
    }

}
