<template>
  <CRow>

    <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
      <form method="POST" @submit="handleSubmit($event, onSubmit)" ref="formData">
        <Field type="hidden" :value="csrfToken" name="_token" />
        <div>
          <CFormLabel class="col-sm-3 lbl-input" require>Code</CFormLabel>
          <Field name="code" v-model="model.code" rules="required|min:8|regex:^([a-zA-Z0-9]+)$" class="form-control" />
          <ErrorMessage class="error" name="code" />
        </div>

        <CFormLabel class="col-sm-3 lbl-input" require>Họ và tên</CFormLabel>
        <Field name="name" v-model="model.name" rules="required" class="form-control" />
        <ErrorMessage class="error" name="name" />
        <div>
          <CFormLabel class="col-sm-3 lbl-input" require>Số điện thoại</CFormLabel>
          <Field name="telephone" type="text" autocomplete="off" v-model="model.telephone" rules="required|digits:10"
            class="form-control" ref="telephone" />
          <ErrorMessage class="error" name="telephone" />
        </div>

        <div>
          <CFormLabel class="col-sm-3 lbl-input" require>Địa chỉ</CFormLabel>
          <Field name="address" type="text" autocomplete="off" v-model="model.address" rules="required|max:255"
            class="form-control" />
          <ErrorMessage class="error" name="address" /><br>
        </div>


        <div class="col-md-12 text-center btn-box">
          <button class="btn btn-primary">ADD</button>
        </div>

      </form>
    </VeeForm>


  </CRow>

</template>

<script>

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
  data: function () {
    return {
      model: {},
    };
  },
  created() {
    let messError = {
      en: {
        fields: {
          code: {
            required: "Mã code không được để trống",
            min: "Mã code từ 8 ký tự trở lên",
            regex: "Mã code khống đúng định dạng",
          },
          name: {
            required: "Họ và tên không được để trống",
          },
          telephone: {
            required: "Số điện thoại không được để trống",
            digits: "Số điện thoai phải là số và 10 ký tự"
          },
          address: {
            required: "Địa chỉ không được để trống",
            max: "Địa chỉ ít hơn 255 ký tự",

          },
        },
      },
    };
    configure({
      generateMessage: localize(messError),
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
  },
};
</script>
<style>
.error{
  color: rgb(209, 41, 41);
}
</style>