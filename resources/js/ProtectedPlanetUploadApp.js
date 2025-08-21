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

import {reactive, ref, watch, toRaw, onMounted, nextTick} from "vue";

import uploadFile from "@modular-forms/js/inputs//upload.vue";


export default class ProtectedPlanetUploadApp extends Base {

    constructor(input_data) {

        const options = {
            name: 'ProtectedPlanetUploadApp',

            props: {
                records: Object
            },

            setup(props, context) {

                let records = reactive(props.records)
                let uploaded = ref(false);

                watch(records, (value) => {
                    uploaded.value = value.dataset_upload.temp_filename !== null;
                });

                return {
                    records,
                    uploaded
                }

            }

        }

        return super(options, input_data)
            .component('upload', uploadFile);
    }
}
