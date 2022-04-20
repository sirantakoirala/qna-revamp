import React, { useEffect, useState } from "react";
import { QuestionModal } from "./QuestionModal";
import { SubjectModal } from "./SubjectModal";
import { Card, Icon, Grid } from "semantic-ui-react";
import { Sidebar } from "./Sidebar";

import {
  collection,
  query,
  onSnapshot,
  orderBy,
  getDocs,
} from "firebase/firestore";
import { db } from "../../firebase-config";
import { Link } from "react-router-dom";
import { useUserContext } from "../../context/userContext";
import QuizModal from "./QuizModal";

const Dashboard = () => {
  const [topics, setTopics] = useState([]);
  const { currentUser } = useUserContext();
  const [subjectOptions, setSubjectOptions] = useState([]);

  const isNotStudentRole = currentUser.role !== "student";
  useEffect(() => {
    async function getTopics() {
      try {
        const q = query(collection(db, "topics"), orderBy("createdAt", "desc"));

        const unsub = await onSnapshot(q, (querySnapshot) => {
          const topics = querySnapshot.docs.map((topic) => topic.data());
          setTopics(topics);
        });

        return unsub;
      } catch (err) {
        console.log(err);
      }
    }
    return getTopics();
  }, []);

  useEffect(() => {
    async function getSubjects() {
      const q = query(collection(db, "subject"));

      const querySnapshot = await getDocs(q);
      const subjects = querySnapshot.docs.map((doc, id) => ({
        value: doc.data().title,
        key: id,
        text: doc.data().title,
      }));
      setSubjectOptions(subjects);
    }
    getSubjects();
  }, []);

  return (
    <Sidebar>
      <h1>Dashboard</h1>

      {isNotStudentRole && (
        <QuizModal subjectOptions={subjectOptions} currentUser={currentUser} />
      )}
      {isNotStudentRole && <SubjectModal />}
      <QuestionModal subjectOptions={subjectOptions} />

      <div>
        <h1>Current Topics</h1>
        <Grid columns="three">
          {topics.map((topic) => {
            return (
              <Grid.Column key={topic.topicId}>
                <Card
                  as={Link}
                  style={{ width: "100%" }}
                  to={`/topic/${topic.topicId}`}
                  header={topic.topicTitle}
                  meta={topic.topicSubject}
                  description={topic.topicDescription}
                  extra={
                    <a>
                      <Icon name="user" />
                      {topic.user}
                    </a>
                  }
                />
              </Grid.Column>
            );
          })}
        </Grid>
      </div>
    </Sidebar>
  );
};

export default Dashboard;
