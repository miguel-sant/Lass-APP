# LASS-APP / API

Lass-APP identifica alimentos em fotos e gera estimativas nutricionais estruturadas em JSON para integração com outros sistemas.

- Recebe uma imagem de alimento e usa um modelo multimodal para detectar os itens visíveis e estimar a porção em gramas.
- Converte cada item detectado em valores nutricionais (kcal, proteína, carboidrato, gordura, fibra) usando um banco local e/ou consultando dinamicamente fontes externas (ex.: USDA) quando o item for desconhecido.
- Escala os valores por porção estimada e agrega os macronutrientes totais do prato.
- Persiste consultas externas no banco local para cache e reaproveitamento.
- Retorna JSON com itens detectados, porções, nutrientes por item, totais e metadados (modelo utilizado, raw output).
- Mantém histórico de análises e pode gerar sugestões alimentares básicas com base no perfil do usuário.

Observação: resultados são estimativas dependentes da qualidade da imagem, do modelo e da fonte de dados; itens marcados como aproximados indicam menor confiança.
