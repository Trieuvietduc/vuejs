<template>
    <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
        <form @submit="handleSubmit($event, onSubmit)" method="post" ref="formData" action="/login">
            <Field type="hidden" :value="csrfToken" name="_token" />
            <div>
                <CFormLabel class="col-sm-3 lbl-input" require>Email</CFormLabel>
                <Field name="email" v-model="model.email" rules="required|email_custom" class="form-control" />
                <ErrorMessage class="error" name="email" />
            </div>
            <CFormLabel class="col-sm-3 lbl-input" require>Mật Khẩu</CFormLabel>
            <Field name="password" v-model="model.password" rules="required|min:8" class="form-control" />
            <ErrorMessage class="error" name="password" />
            <div class="col-md-12 text-center btn-box">
                <button class="btn btn-primary">Login</button>
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
                    email: {
                        required: "Email không được để trống",
                        email: "Email không đúng định dạng",
                        email_custom: "email không đúng"
                        
                    },
                    password: {
                        required: "Mật khẩu không được để trống",
                        min: "Mật khẩu từ 8 ký tự trở lên",
                    }
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
        let that = this;
        defineRule("email_custom", (value) => {
            return axios
                .post(that.data.urlCheckEmail, {
                    _token: Laravel.csrfToken,
                    fales: 1,
                    value: value,
                })
                .then(function (response) {
                    console.log(response.data);
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