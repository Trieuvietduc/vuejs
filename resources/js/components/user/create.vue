<template>
    <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
        <form @submit="handleSubmit($event, onSubmit)" method="post" ref="formData" action="/user">
            <Field type="hidden" :value="csrfToken" name="_token" />
            <div>
                <CFormLabel class="col-sm-3 lbl-input" require>Họ và Tên</CFormLabel>
                <Field name="name" v-model="model.name" rules="required" class="form-control" />
                <ErrorMessage class="error" name="name" />
            </div>
            <CFormLabel class="col-sm-3 lbl-input" require>email</CFormLabel>
            <Field name="email" v-model="model.email" rules="required|email|unique_custom" class="form-control" />
            <ErrorMessage class="error" name="email" />
            <div>
                <CFormLabel class="col-sm-3 lbl-input" require>Mật khẩu</CFormLabel>
                <Field name="password" type="password" autocomplete="off" v-model="model.telephone"
                    rules="required|min:8" class="form-control" ref="password" />
                <ErrorMessage class="error" name="password" />
            </div>
            <div>
                <CFormLabel class="col-sm-3 lbl-input" require>Chức vụ</CFormLabel>
                <Field  name="role_id" as="select" rules="required" class="form-control" ref="role_id">
                    <option value="1">user</option>
                    <option value="2">admin</option>
                    <option value="3">system_admin</option>
                </Field >
                <ErrorMessage class="error" name="role_type" /><br>
            </div>
            <div class="col-md-12 text-center btn-box">
                <button class="btn btn-primary">ADD</button>
            </div>

        </form>
    </VeeForm>

</template>
<script>
import $ from "jquery";
import axios from "axios";
import {
    Form as VeeForm,
    Field,
    ErrorMessage,
    defineRule,
    configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
export default {
    setup() {
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
    },
    components: {
        VeeForm,
        Field,
        ErrorMessage,

    },
    props: ["data"],
    data() {
        return {
            csrfToken: Laravel.csrfToken,
            model: {},
        };
    },
    created() {
        let messError = {
            en: {
                fields: {
                    name: {
                        required: "Họ và Tên không được để trống",

                    },
                    email: {
                        required: "Email không được để trống",
                        email: "Email không đúng định dạng",
                        unique_custom: "Email này đã được đăng kí trước đây.",
                    },
                    password: {
                        required: "Mật khẩu không được để trống",
                        min: "Mật khẩu từ 8 ký tự trở lên",
                    },
                    role_id: {
                        required: "Chức vụ không được để trống",
                    },
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
        let that = this;
        defineRule("unique_custom", (value) => {
            return axios
                .post(that.data.urlCheckEmail, {
                    _token: Laravel.csrfToken,
                    value: value,
                })
                .then(function (response) {
                    console.log(response);
                    return response.data.valid;
                })
                .catch((error) => { });
        });
    },
    methods: {
        onInvalidSubmit({ values, errors, results }) {
            let firstInputError = Object.entries(errors)[0][0];
            this.$el.querySelector("input[name=" + firstInputError + "]").focus();
            $("html, body").animate(
                {
                    scrollTop:
                        $("input[name=" + firstInputError + "]").offset().top - 150,
                },
                500
            );
        },
        onSubmit() {
            this.$refs.formData.submit();
        },
    }
}
</script>
<style>
.error {
    color: red;
}
</style>